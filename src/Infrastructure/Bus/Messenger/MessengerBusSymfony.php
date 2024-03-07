<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Messenger;

use App\Domain\Shared\Event\Event;
use App\Domain\Shared\Messenger\MessengerBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerBusSymfony implements MessengerBusInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(Event ...$messenger): void
    {
        try {
            foreach ($messenger as $event) {
                $this->bus->dispatch($event);
            }
        } catch (\Exception $e) {
            // TODO Si se produce algun error notificar
        }
    }
}
