<?php

namespace Modules\Auth\Enums;

enum UserType: int
{
    case ADMIN = 1;
    case DELIVERY = 2;
    case USER = 3;

    public static function matchEnum(int|string $value): self
    {
        return match ($value) {
            1, '1' => self::ADMIN,
            2, '2' => self::DELIVERY,
            3, '3' => self::USER,
        };
    }

    public static function tableComment(): string
    {
        $labels = '';
        for ($i = 0; $i < count(self::cases()); $i++) {
            $case = self::cases()[$i];
            if ($i == count(self::cases()) - 1) {
                $labels = "$labels{$case->value} => {$case->label()}";
                continue;
            }
            $labels = "$labels{$case->value} => {$case->label()}, ";
        }
        return $labels;
    }

    public function label(): string
    {
        return ucfirst(strtolower(str_replace('_', ' ', $this->name)));
    }
}
