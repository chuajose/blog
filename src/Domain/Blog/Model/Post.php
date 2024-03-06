<?php

declare(strict_types=1);

namespace App\Domain\Blog\Model;

use App\Domain\User\Model\User;

final class Post
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

    public static function create(int $id, string $title, string $body, User $author): self
    {
        return new self($id, $title, $body, new \DateTimeImmutable('now'), $author);
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
}

