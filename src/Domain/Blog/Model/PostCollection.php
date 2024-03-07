<?php

declare(strict_types=1);

namespace App\Domain\Blog\Model;

class PostCollection
{
    /**
     * @param array<int, Post> $items
     */
    public function __construct(private array $items, private readonly int $total)
    {
        foreach ($items as $item) {
            if (!$item instanceof Post) {
                throw new \InvalidArgumentException('The object is not an instance of Post', 500);
            }
        }
    }

    /** @return \ArrayIterator<int, Post> */
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

    /** @return array<int, Post> */
    protected function items(): array
    {
        return $this->items;
    }

    public function add(Post $item): void
    {
        $this->items[] = $item;
    }

    public function clear(): void
    {
        $this->items = [];
    }
}
