<?php

namespace App\Models\Objects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Mrzlanx532\LaravelBasicComponents\Traits\Model\UploadFile\UploadFile;

/**
 * \App\Models\Obj
 *
 * @property int id
 * @property bool|null example_checkbox
 * @property Carbon|null example_date
 * @property Carbon|null example_datetime
 * @property string|null example_editor
 * @property string|null example_input
 * @property string|null example_input_file
 * @property string|null example_select
 * @property string|null example_select_wrap
 * @property string|null example_switcher
 * @property string|null example_textarea
 *
 * @method static Builder|Obj query()
 * @method static Obj|null find($id)
 * @method static Obj findOrFail($id)
 *
 * @mixin Model
 */
class Obj extends Model
{
    use UploadFile;

    public static array $filePropertiesWithSettings = [
        'example_input_file' => null,
    ];

    protected $table = 'objects_objects';

    public $timestamps = false;
}