<?php

namespace App;

/**
 * App\StudentInformation
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereHighlight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereLkA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereLkB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereMissLeast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereMissMost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereMotto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation wherePhotoNewPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation wherePhotoOldPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereSlogan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereSoundtrack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereStrengths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentInformation whereWeaknesses($value)
 * @mixin \Eloquent
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
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
