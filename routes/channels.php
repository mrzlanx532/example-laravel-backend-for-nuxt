<?php

use App\Broadcasting\ManagerChannel;
use App\Broadcasting\UserChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Broadcast::channel('user.{userId}', UserChannel::class);
Broadcast::channel('manager.{managerId}', ManagerChannel::class);
