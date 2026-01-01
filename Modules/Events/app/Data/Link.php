<?php

namespace Modules\Events\Data;

use DateMalformedStringException;
use DateTime;
use DateTimeInterface;
use Modules\Events\Exceptions\InvalidLink;
use Modules\Events\Generators\Generator;
use Modules\Events\Generators\Ics;

/**
 * @property-read string $title
 * @property-read DateTimeInterface|DateTime|\DateTimeImmutable $from
 * @property-read DateTimeInterface|DateTime|\DateTimeImmutable $to
 * @property-read string $description
 * @property-read string $address
 * @property-read bool $allDay
 */
class Link
{
    public string $title;

    public DateTimeInterface|DateTime $from;

    public DateTimeInterface|DateTime $to;

    public string $description;

    public bool $allDay;

    public ?string $address = null;

    public function __construct(string $title, DateTimeInterface $from, DateTimeInterface $to, bool $allDay = false)
    {
        $this->title = $title;
        $this->allDay = $allDay;

        if ($to < $from) {
            throw InvalidLink::invalidDateRange($from, $to);
        }

        $this->from = clone $from;
        $this->to = clone $to;
    }

    /**
     * @throws InvalidLink
     */
    public static function create(string $title, DateTimeInterface $from, DateTimeInterface $to, bool $allDay = false): static
    {
        return new static($title, $from, $to, $allDay);
    }

    /**
     * @throws DateMalformedStringException
     */
    public static function createAllDay(string $title, DateTimeInterface $fromDate, int $numberOfDays = 1): self
    {
        $from = (clone $fromDate)->modify('midnight');
        $to = (clone $from)->modify("+$numberOfDays days");

        return new self($title, $from, $to, true);
    }

    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function address(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function formatWith(Generator $generator): string
    {
        return $generator->generate($this);
    }

    public function ics(array $options = []): string
    {
        return $this->formatWith(new Ics($options));
    }

    public function __get($property)
    {
        return $this->$property;
    }
}
