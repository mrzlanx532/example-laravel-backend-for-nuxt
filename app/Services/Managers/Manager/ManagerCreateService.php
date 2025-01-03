<?php

namespace App\Services\Managers\Manager;

use App\Models\Managers\Manager;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Hash;

class ManagerCreateService extends Service
{
    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:managers_managers,email',
            'password' => 'required|string|max:255'
        ];
    }

    public function handle()
    {
        $m = new Manager;
        $m->name = $this->params['name'];
        $m->email = $this->params['email'];
        $m->password = Hash::make($this->params['password']);
        $m->save();
    }
}