<?php

declare(strict_types=1);

namespace App\Domain\Blog\Model;

use App\Domain\User\Model\User;

final class Post implements \JsonSerializable
{
    private int $id;
    private string $title;
    private string $body;
    private \DateTimeImmutable $createdAt;
    private User $author;

    private function __construct(int $id, string $title, string $body, \DateTimeImmutable $createdAt, User $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->createdAt = $createdAt;
        $this->author = $author;
    }

    public static function create(string $title, string $body, User $author): self
    {
        return new self(0, $title, $body, new \DateTimeImmutable('now'), $author);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function author(): User
    {
        return $this->author;
    }

    /**
     * @return array<string, array<string, string|int>|int|string>
     */
    #[\Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'author' => $this->author->jsonSerialize(),
        ];
    }
}
