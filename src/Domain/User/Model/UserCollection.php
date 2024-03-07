<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

class UserCollection
{
    /**
     * @param array<int, User> $items
     */
    public function __construct(private array $items, private readonly int $total)
    {
        foreach ($items as $item) {
            if (!$item instanceof User) {
                throw new \InvalidArgumentException('The object is not an instance of User', 500);
            }
        }
    }

    /** @return \ArrayIterator<int, User> */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items());
    }

    public function total(): int
    {
        return $this->total;
    }

    public function count(): int
    {
        return count($this->items());
    }

    /** @return array<int, User> */
    protected function items(): array
    {
        return $this->items;
    }

    public function add(User $item): void
    {
        $this->items[] = $item;
    }

    public function clear(): void
    {
        $this->items = [];
    }
}
