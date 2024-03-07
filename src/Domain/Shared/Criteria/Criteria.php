<?php

declare(strict_types=1);

namespace App\Domain\Shared\Criteria;


final readonly class Criteria
{
    public function __construct(
        private Order $order,
        private ?int $offset,
        private ?int $limit
    ) {}


    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

}