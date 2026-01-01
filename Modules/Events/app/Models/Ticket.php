<?php

namespace Modules\Events\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelArchivable\Archivable;
use LaravelPublishable\Publishable;
use Modules\Events\Database\Factories\TicketFactory;
use Spatie\Translatable\HasTranslations;

class Ticket extends Model
{
    use Archivable;
    use HasFactory;
    use HasTranslations;
    use Publishable;
    use SoftDeletes;

    protected $table = 'tickets';

    public array $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'description',
        'url',
        'is_active',
        'extras',
    ];

    protected static function newFactory(): TicketFactory
    {
        return TicketFactory::new();
    }

    public function ticketOptions(): HasMany
    {
        return $this->hasMany(TicketOption::class, 'ticket_id', 'id');
    }

    public function events()
    {
        return $this->belongsToMany(
            Ticket::class,
            'ticket_assignments',
        )->using(TicketAssignment::class);
    }

    public function toArray(): array
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }
}
