<?php

namespace App\Definitions;

use Mrzlanx532\LaravelBasicComponents\Definition\Definition;

class LocaleDefinition extends Definition
{
    const ru = 'ru';
    const en = 'en';

    public static function items(): array
    {
        return [
            self::ru => [
                'id' => self::ru,
                'title' => 'Русский',
            ],
            self::en => [
                'id' => self::en,
                'title' => 'Английский',
            ]
        ];
    }
}