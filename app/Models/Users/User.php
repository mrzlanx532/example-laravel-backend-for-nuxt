<?php

namespace App\Models\Users;

use Mrzlanx532\LaravelBasicComponents\Traits\Model\UploadFile\UploadFile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * \App\Models\Users\User
 *
 * @property int id
 * @property string name
 * @property string email
 * @property Carbon|null email_verified_at
 * @property string password
 * @property string|null remember_token
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property Carbon|null deleted_at
 * @property string|null email_new
 * @property string|null picture
 * @property string|null phone
 * @property string state_id
 * @property string subscription_type_id
 * @property Carbon|null subscription_till
 * @property Carbon|null subscription_till_for_exclusive_tracks
 * @property string|null description
 * @property string|null first_name
 * @property string|null last_name
 * @property string|null company_name
 * @property string|null company_address
 * @property string|null company_index
 * @property string|null company_city
 * @property int|null company_country_id
 * @property Carbon|null last_activity_at
 * @property string|null temp_hash
 * @property string|null password_new
 * @property int views_counter
 * @property int downloads_counter
 * @property int company_business_type_id
 * @property string|null about
 * @property string job_title
 * @property string|null company_url
 * @property string|null locale_id
 * @property string|null content

 * @method static Builder|User query()
 * @method static Builder|User findOrFail($id)
 * @mixin Model
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use UploadFile;
    use SoftDeletes;
    use HasApiTokens;

    protected $table = 'users_users';

    public static array $filePropertiesWithSettings = [
        'picture' => null,
    ];

    public function isSubscriptionEnded(): bool
    {
        if ($this->subscription_till_for_exclusive_tracks === null) {
            return true;
        }

        if (Carbon::parse($this->subscription_till_for_exclusive_tracks)->endOfDay()->timestamp < Carbon::now()->timestamp) {
            return true;
        }

        return false;
    }
}