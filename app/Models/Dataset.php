<?php

namespace App\Models;

use App\DatasetResource;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Dataset
 *
 * @property int $id
 * @property array $name
 * @property string|null $source_url
 * @property string|null $licence
 * @property string|null $categories
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DatasetResource[] $resources
 * @property-read int|null $resources_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereLicence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereSourceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dataset whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dataset extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    public function resources()
    {
        return $this->hasMany(DatasetResource::class)->orderByDesc('updated_at');
    }

    public function getCategoriesAttribute($value)
    {
        $categories = explode(', ', $value);

        if ($categories != [""]) {
            return $categories;
        } else {
            return array();
        }
    }
}
