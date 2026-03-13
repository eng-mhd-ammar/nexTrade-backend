<?php

namespace Modules\Auth\Enums;

enum Gender: int
{
    case FEMALE = 0;
    case MALE = 1;

    public static function matchEnum(int|string $value): self
    {
        return match ((int) $value) {
            0 => self::FEMALE,
            1 => self::MALE,
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
