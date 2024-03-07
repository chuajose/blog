<?php

declare(strict_types=1);

namespace App\Domain\Shared\Criteria;

enum OrderType: string
{
    case ASC = 'asc';
    case DESC = 'desc';
    case NONE = 'none';

    public function isNone(): bool
    {
        return $this->value === self::NONE->value;
    }

    public function value(): string
    {
        return $this->name;
    }
}
