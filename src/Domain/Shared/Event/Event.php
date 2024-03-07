<?php

declare(strict_types=1);

namespace App\Domain\Shared\Event;

interface Event
{
    /**
     * @return array<string, int|string>
     */
    public function payload(): array;

    public function eventName(): string;
}
