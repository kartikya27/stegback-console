<?php
namespace Kartikey\PanelPulse\App\Enums;

enum Status: int {
    case ACTIVE = 1;
    case INACTIVE = 0;

    public function label(): string {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }

    public static function all(): array {
        return array_combine(
            array_map(fn($case) => $case->value, self::cases()),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }
}
