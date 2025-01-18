<?php

namespace Modules\Management\Models;

use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Management\Database\Factories\GroupFactory;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'organisation_id'];

    // MARK: - Relations -

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    protected static function newFactory(): GroupFactory
    {
        return GroupFactory::new();
    }
}
