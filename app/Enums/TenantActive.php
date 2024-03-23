<?php

namespace App\Enums;

enum TenantActive: string
{
    case Y = "Ativo";
    case N = "Inativo";

    public static function fromValue(string $name): string
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status->value;
            }
        }
        throw new \ValueError("$status is nor a valid");
    }
}
