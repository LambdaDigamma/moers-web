<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\DatasetResource
 *
 * @property int                                                                                                $id
 * @property string                                                                                             $name
 * @property string|null                                                                                        $source_url
 * @property string                                                                                             $format
 * @property string|null                                                                                        $error
 * @property int|null                                                                                           $auto_updating_interval
 * @property int                                                                                                $dataset_id
 * @property \Illuminate\Support\Carbon|null                                                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                                                    $updated_at
 * @property-read \App\Models\Dataset                                                                           $dataset
 * @property-read mixed                                                                                         $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null                                                                                      $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereAutoUpdatingInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereDatasetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereSourceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DatasetResource whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DatasetResource extends Model implements HasMedia
{

    use HasTranslations;
    use InteractsWithMedia;

    public $translatable = ['name'];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

}
