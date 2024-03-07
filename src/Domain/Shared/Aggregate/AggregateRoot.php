<?php

declare(strict_types=1);

namespace App\Domain\Shared\Aggregate;

use App\Domain\Shared\Event\Event;

abstract class AggregateRoot
{
    /**
     * @var array<int, Event>
     */
    private array $domainEvents = [];

    /**
     * @return array<int, Event>
     */
    final public function pullDomainEvents(): array
    {
        $domainEventsPull = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEventsPull;
    }

    final public function record(Event $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }

    /**
     * @return array<int, Event>
     */
    final public function getEvents(): array
    {
        return $this->domainEvents;
    }
}
