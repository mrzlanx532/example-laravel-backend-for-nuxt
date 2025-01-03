<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Auth;

class UserSelfProfilePictureUpdateService extends Service
{
    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'picture' => 'nullable|image|max:10240',
        ];
    }

    public function handle()
    {
        /* @var $user User */
        $user = Auth::user();

        $user->picture = array_key_exists('picture', $this->params) ? $this->params['picture'] : $user->picture;
        $user->save();
    }
}