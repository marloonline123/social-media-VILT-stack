<?php

namespace App\Http\Controllers;

use App\Events\GroupJoinRequested;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupUserResource;
use App\Http\Resources\PostAttachmentResource;
use App\Http\Resources\PostResource;
use App\Mail\GroupInvitaionMail;
use App\Models\BaseModel;
use App\Models\Group;
use App\Models\GroupUserInvitation;
use App\Models\Post;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $posts = Post::with('user', 'attachments', 'likes', 'comments.user')->where('group_id', $request->group)->latest()->take(10)->offset($offset)->get();
        return response()->json(['posts' => PostResource::collection($posts)]);
    }

    public function posts(Request $request, string $id)
    {
        $offset = $request->offset ?? 0;
        $posts = Post::with('user', 'attachments', 'likes', 'comments.user')->where('group_id', $id)->latest()->take(10)->offset($offset)->get();
        return response()->json(['posts' => PostResource::collection($posts)]);
    }

    public function store(GroupRequest $request)
    {
        Gate::authorize('create', Group::class);
        $slug = BaseModel::generateRandomCharachters('G');
        $data = array_merge($request->validated(), ['slug' => $slug, 'user_id' => Auth::id(), 'role' => 'admin']);
        $group = Group::create($data);
        $group->members()->create(['user_id' => Auth::id(), 'status' => 'approved']);
        return redirect()->route('groups.show', $group->slug);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $group = Group::with([
            'user',
            'posts',
            'members',
            'invitations'
        ])->where('slug', $slug)->firstOrFail();

        return inertia('GroupPage', [
            'group' => new GroupResource($group),
            'members' => GroupUserResource::collection($group->members()->approved()->get()),
            'requests' => GroupUserResource::collection($group->members()->pending()->get()),
            'posts' => PostResource::collection($group->posts()->latest()->get()),
            'admins' => GroupUserResource::collection($group->members()->admin()->take(5)->get()),
            'attachments' => PostAttachmentResource::collection($group->attachments),
        ]);
    }
    
    public function uploadAvatar(Request $request, string $slug)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:10240'],
        ]);
        $group = Group::where('slug', $slug)->firstOrFail();
        Gate::authorize('update', $group);
        $avatar = FileService::uploadFile($request->file('avatar'), 'groups/avatars', crop: ['crop' => true, 'width' => 500, 'ratioX' => 1, 'ratioY' => 1]);
        $group->update(['avatar' => $avatar]);

        return back();
    }
    
    public function uploadCover(Request $request, string $slug)
    {
        $request->validate([
            'cover' => ['required', 'image', 'max:10240'],
        ]);
        $group = Group::where('slug', $slug)->firstOrFail();
        Gate::authorize('update', $group);
        $cover = FileService::uploadFile($request->file('cover'), 'groups/covers', crop: ['crop' => true, 'width' => 1080, 'ratioX' => 4, 'ratioY' => 1]);
        $group->update(['cover' => $cover]);

        return back();
    }

    public function update(GroupRequest $request, Group $group)
    {
        Gate::authorize('update', $group);
        $group->update($request->validated());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        Gate::authorize('delete', $group);
        $group->delete();
        return redirect()->route('home');
    }


    public function inviteMember(Request $request, string $slug)
    {
        $request->validate([
            'invited_member' => ['required', 'string', 'max:255'],
        ]);
        $group = Group::where('slug', $slug)->firstOrFail();
        Gate::authorize('invite', $group);
        $user = User::where('username', $request->invited_member)->orWhere('email', $request->invited_member)->firstOrFail();
        try {
            $group->invitations()->create(['user_id' => $user->id]);
            Mail::to($user->email)->send(new GroupInvitaionMail($group, $user));
        } catch (\Throwable $th) {
            Log::error('error sending mail' . $th);
        }
        return back();
    }

    public function acceptInvitation(Request $request, string $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        $group->invitations()->where('user_id', Auth::id())->delete();
        $group->members()->create(['user_id' => Auth::id(), 'status' => 'approved']);
        return back();
    }

    public function declineInvitation(Request $request, string $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        $group->invitations()->where('user_id', Auth::id())->delete();
        return back();
    }

    public function joinGroup(Request $request, string $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        if ($group->members()->where('user_id', Auth::id())->exists()) {
            return back()->withErrors(['message' => 'You are already a member of this group']);
        }
        if ($group->auto_approval) {
            $group->members()->create(['user_id' => Auth::id(), 'status' => 'approved']);
            return back();
        }
        $group->members()->create(['user_id' => Auth::id(), 'status' => 'pending']);
        event(new GroupJoinRequested($group, Auth::user()));
        return back();
    }

    public function leaveGroup(Request $request, string $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        $group->members()->where('user_id', Auth::id())->delete();
        return back();
    }

    public function approveMember(Request $request, string $slug)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        
        $group = Group::where('slug', $slug)->firstOrFail();
        Gate::authorize('approve', $group);
        $group->members()->where('user_id', $request->user_id)->update(['status' => 'approved']);
        return back();
    }

    public function rejectMember(Request $request, string $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        Gate::authorize('reject', $group);
        $group->members()->where('user_id', $request->user_id)->update(['status' => 'rejected']);
        return back();
    }

    public function changeRole(Request $request, string $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        Gate::authorize('modify-member', $group);
        $group->members()->where('user_id', $request->member_id)->update(['role' => $request->role]);
        return back();
    }

    public function removeMember(Request $request, string $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        Gate::authorize('modify-member', $group);
        $group->members()->where('user_id', $request->member_id)->delete();
        return back();
    }
}
