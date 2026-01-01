<?php

namespace Modules\Events\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Events\database\factories\TicketOptionFactory;
use Spatie\Translatable\HasTranslations;

class TicketOption extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'ticket_options';

    protected array $translatable = [
        'name',
    ];

    protected $fillable = [
        'name',
        'price',
        'ticket_id',
        'url',
        'extras',
    ];

    protected static function newFactory(): TicketOptionFactory
    {
        return TicketOptionFactory::new();
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
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
