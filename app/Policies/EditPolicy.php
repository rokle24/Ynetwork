<?php

namespace App\Policies;

use App\Models\User;

class EditPolicy
{
    public function update(User $user, User $profileUser): bool
    {
        return $user->id === $profileUser->id;
    }
}
