<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Auth;

class UserSetLocaleIdService extends Service
{
    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'locale_id' => 'required|in:en,ru'
        ];
    }

    public function handle()
    {
        /* @var $currentUser User */
        $currentUser = Auth::user();

        $currentUser->locale_id = $this->params['locale_id'];
        $currentUser->save();
    }
}