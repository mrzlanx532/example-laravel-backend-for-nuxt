<?php

namespace App\Events;

trait BaseSocketEvent
{
    public function broadcastAs(): string
    {
        return basename(str_replace('\\', '/', get_class($this)));
    }
}
