<?php

declare(strict_types=1);

namespace App\Enums;

enum PushNotificationTopic: string
{
    case All = 'all';
    case AllDe = 'all_de';
    case AllEn = 'all_en';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(
            static fn (self $topic): string => $topic->value,
            self::cases(),
        );
    }

    /**
     * @return array<string, string>
     */
    public static function promptOptions(): array
    {
        return [
            self::All->value => 'All devices',
            self::AllDe->value => 'German devices',
            self::AllEn->value => 'English devices',
        ];
    }
}
