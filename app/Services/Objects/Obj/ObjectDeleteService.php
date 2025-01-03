<?php

namespace App\Services\Objects\Obj;

use App\Models\Objects\Obj;
use Mrzlanx532\LaravelBasicComponents\Service\Service;

class ObjectDeleteService extends Service
{
    public function getRules(): array
    {
        return [
            'id' => 'required|int',
        ];
    }

    public function handle(): Obj
    {
        $pencil = Obj::find($this->params['id']);
        $pencil->delete();

        return $pencil;
    }
}