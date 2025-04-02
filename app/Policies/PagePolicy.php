<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PagePolicy
{
    public function create(User $user): bool
    {
        return !$user->isDisabled;
    }

    public function update(User $user, Page $page): bool
    {
        return $user->id === $page->user_id;
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->id === $page->user_id;
    }
}
