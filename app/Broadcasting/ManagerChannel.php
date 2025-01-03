<?php

namespace App\Broadcasting;

use App\Models\Managers\Manager;

class ManagerChannel
{
    public function join(Manager $user, int $managerId): bool
    {
        return $user->id === $managerId;
    }
}
