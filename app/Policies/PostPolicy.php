<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        return $user->isAdmin() || $user->id === $post->user_id || $post->status === 'approved';
    }

    public function create(User $user): bool
    {
        return $user->role === 'citizen' || $user->role === 'admin';
    }

    public function update(User $user, Post $post): bool
    {
        return $user->isAdmin() || $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function approve(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function reject(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }
}
