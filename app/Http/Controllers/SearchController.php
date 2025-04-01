<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request) {
        $searchTerm = $request->term;
        $usersData = User::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('username', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('bio', 'LIKE', '%' . $searchTerm . '%')
            ->take(10)
            ->get();

        $groupsData = Group::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('about', 'LIKE', '%' . $searchTerm . '%')
            ->take(10)
            ->get();

        $data = [
            'usersData' => UserResource::collection($usersData),
            'groupsData' => GroupResource::collection($groupsData),
        ];

        return response()->json($data);
    }
}
