<?php

namespace App\Definitions\Users\User;

use Mrzlanx532\LaravelBasicComponents\Definition\Definition;

class StateDefinition extends Definition
{
    const ACTIVE = 'ACTIVE';
    const PENDING = 'PENDING';
    const DISABLED = 'DISABLED';

    public static function items(): array
    {
        return [
            self::ACTIVE => [
                'id' => self::ACTIVE,
                'title' => 'Активен',
            ],
            self::PENDING => [
                'id' => self::PENDING,
                'title' => 'Ожидание обработки',
            ],
            self::DISABLED => [
                'id' => self::DISABLED,
                'title' => 'Заблокирован',
            ],
        ];
    }
}