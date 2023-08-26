<?php

namespace App\Enums;

/**
 * Request status
 */
enum Status: string
{
    case active = 'active';

    case resolved = 'resolved';

    /**
     * @return array<string, string>
     */
    public static function list(): array
    {
        return [
            self::active->value => self::getLabel(self::active->value),
            self::resolved->value => self::getLabel(self::resolved->value),
        ];
    }

    public static function getLabel(string $value): ?string
    {
        return match ($value) {
            self::active->value => 'Active',
            self::resolved->value => 'Resolved',
            default => null
        };
    }

    public function label(): string
    {
        return self::getLabel($this->value);
    }

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
