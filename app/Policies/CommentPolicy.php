<?php

namespace App\Policies;

use App\Models\PostComment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostComment $postComment): bool
    {
        return !$user->isDisabled && !$postComment->post->isDisabled && $user->id === $postComment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostComment $postComment): bool
    {
        return !$user->isDisabled && !$postComment->post->isDisabled && $user->id === $postComment->user_id;
    }

    /**
     * Determine whether the user can reply the model.
     */
    public function reply(User $user, PostComment $postComment): bool
    {
        return !$user->isDisabled && !$postComment->post->isDisabled;
    }
}
