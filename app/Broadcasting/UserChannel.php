<?php

namespace App\Broadcasting;

use App\Models\Users\User;

class UserChannel
{
    public function join(User $user, int|string $userId): bool
    {
        return true;
    }
}
