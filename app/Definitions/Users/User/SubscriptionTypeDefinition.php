<?php

namespace App\Definitions\Users\User;

use Mrzlanx532\LaravelBasicComponents\Definition\Definition;

class SubscriptionTypeDefinition extends Definition
{
    const NONE = 'NONE';
    const ONLY_MUSIC = 'ONLY_MUSIC';
    const ONLY_SOUNDS = 'ONLY_SOUNDS';
    const MUSIC_AND_SOUNDS = 'MUSIC_AND_SOUNDS';

    public static function items(): array
    {
        return [
            self::NONE => [
                'id' => self::NONE,
                'title' => 'Подписка отсутствует',
            ],
            self::ONLY_MUSIC => [
                'id' => self::ONLY_MUSIC,
                'title' => 'Только музыка',
            ],
            self::ONLY_SOUNDS => [
                'id' => self::ONLY_SOUNDS,
                'title' => 'Только шумы',
            ],
            self::MUSIC_AND_SOUNDS => [
                'id' => self::MUSIC_AND_SOUNDS,
                'title' => 'Музыка и шумы',
            ]
        ];
    }
}