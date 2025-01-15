<?php

namespace Modules\Events\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Events\Models\Ticket;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
        ];
    }

    public function published(): TicketFactory
    {
        return $this->state(fn () => [
            'published_at' => now(),
        ]);
    }

    public function notPublished(): TicketFactory
    {
        return $this->state(fn () => [
            'published_at' => null,
        ]);
    }

    public function archived(): TicketFactory
    {
        return $this->state(fn () => [
            'archived_at' => now(),
        ]);
    }

    public function notArchived(): TicketFactory
    {
        return $this->state(fn () => [
            'archived_at' => null,
        ]);
    }
}
