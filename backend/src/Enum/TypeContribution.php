<?php

namespace App\Enum;

enum TypeContribution: string
{
    case SIGNALEMENT = 'signalement';
    case IDEE = 'idee';

    public function libelle(): string
    {
        return match ($this) {
            self::SIGNALEMENT => 'Signalement',
            self::IDEE => 'Idée',
        };
    }
}
