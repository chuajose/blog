<?php

declare(strict_types=1);

namespace App\Domain\Shared\Messenger;

use App\Domain\Shared\Event\Event;

interface MessengerBusInterface
{
    public function dispatch(Event ...$messenger): void;
}
