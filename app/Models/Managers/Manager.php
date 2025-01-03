<?php

namespace App\Models\Managers;

use Mrzlanx532\LaravelBasicComponents\Traits\Model\UploadFile\UploadFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * \App\Models\Managers\Manager
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string|null picture
 * @property string password
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property Carbon|null deleted_at

 * @method static Builder|Manager query()
 * @mixin Model
 */
class Manager extends Authenticatable
{
    use UploadFile;
    use SoftDeletes;
    use HasApiTokens;

    protected $table = 'managers_managers';

    public static array $filePropertiesWithSettings = [
        'picture' => null,
    ];
}