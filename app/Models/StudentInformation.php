<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\StudentInformation
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $nickname
 * @property string $birthday
 * @property string $slogan
 * @property string $motto
 * @property string $strengths
 * @property string $weaknesses
 * @property string $lkA
 * @property string $lkB
 * @property string $highlight
 * @property string $soundtrack
 * @property string $miss_least
 * @property string $miss_most
 * @property string|null $photo_old_path
 * @property string|null $photo_new_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|StudentInformation newModelQuery()
 * @method static Builder|StudentInformation newQuery()
 * @method static Builder|StudentInformation query()
 * @method static Builder|StudentInformation whereBirthday($value)
 * @method static Builder|StudentInformation whereCreatedAt($value)
 * @method static Builder|StudentInformation whereHighlight($value)
 * @method static Builder|StudentInformation whereId($value)
 * @method static Builder|StudentInformation whereLkA($value)
 * @method static Builder|StudentInformation whereLkB($value)
 * @method static Builder|StudentInformation whereMissLeast($value)
 * @method static Builder|StudentInformation whereMissMost($value)
 * @method static Builder|StudentInformation whereMotto($value)
 * @method static Builder|StudentInformation whereName($value)
 * @method static Builder|StudentInformation whereNickname($value)
 * @method static Builder|StudentInformation wherePhotoNewPath($value)
 * @method static Builder|StudentInformation wherePhotoOldPath($value)
 * @method static Builder|StudentInformation whereSlogan($value)
 * @method static Builder|StudentInformation whereSoundtrack($value)
 * @method static Builder|StudentInformation whereStrengths($value)
 * @method static Builder|StudentInformation whereUpdatedAt($value)
 * @method static Builder|StudentInformation whereUserId($value)
 * @method static Builder|StudentInformation whereWeaknesses($value)
 * @mixin Eloquent
 */
class StudentInformation extends Model
{

    protected $fillable = [
        'name',
        'nickname',
        'birthday',
        'slogan',
        'motto',
        'strengths',
        'weaknesses',
        'lkA',
        'lkB',
        'highlight',
        'soundtrack',
        'miss_least',
        'miss_most',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
