<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Group $group): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return !$user->isDisabled;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Group $group): bool
    {
        return $user->id == $group->user_id;
    }

    /**
     * Determine whether the user can invite members.
     */
    public function invite(User $user, Group $group): bool
    {
        return $group->members()->where('user_id', $user->id)->where('role', 'admin')->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Group $group): bool
    {
        return $user->id == $group->user_id;
    }

    /**
     * Determine whether the user can approve members.
     */
    public function approve(User $user, Group $group): bool
    {
        return $group->members()->where('user_id', $user->id)->where('role', 'admin')->exists();
    }

    /**
     * Determine whether the user can reject members.
     */
    public function reject(User $user, Group $group): bool
    {
        return $group->members()->where('user_id', $user->id)->where('role', 'admin')->exists();
    }

    /**
     * Determine whether the user can modify members.
     */
    public function modifyMember(User $user, Group $group): bool
    {
        return $group->members()->where('user_id', $user->id)->where('role', 'admin')->exists();
    }
}
