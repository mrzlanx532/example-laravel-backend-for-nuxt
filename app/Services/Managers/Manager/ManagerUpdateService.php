<?php

namespace App\Services\Managers\Manager;

use App\Models\Managers\Manager;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ManagerUpdateService extends Service
{
    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'id' => 'required|int',
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'password' => 'nullable|string|max:255'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function handle()
    {
        $managerWithPassedEmailExists = Manager::query()
            ->where('email', $this->params['email'])
            ->where('id', '!=', $this->params['id'])
            ->first();

        if ($managerWithPassedEmailExists) {
            throw ValidationException::withMessages([
                'email' => trans('validation.unique', [
                    'attribute' => 'email'
                ])
            ]);
        }

        $manager = Manager::query()
            ->where('id', $this->params['id'])
            ->firstOrFail();

        $manager->email = $this->params['email'];
        $manager->name = $this->params['name'];
        $manager->password = isset($this->params['password']) ? Hash::make($this->params['password']) : $manager->password;
        $manager->save();
    }
}