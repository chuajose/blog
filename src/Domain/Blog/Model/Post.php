<?php

declare(strict_types=1);

namespace App\Domain\Blog\Model;

use App\Domain\Blog\Event\PostWasCreated;
use App\Domain\Shared\Aggregate\AggregateRoot;
use App\Domain\User\Model\User;
use Symfony\Component\Uid\Uuid;

final class Post extends AggregateRoot implements \JsonSerializable
{
    private Uuid $id;
    private string $title;
    private string $body;
    private \DateTimeImmutable $createdAt;
    private User $author;

    private function __construct(Uuid $id, string $title, string $body, \DateTimeImmutable $createdAt, User $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->createdAt = $createdAt;
        $this->author = $author;
    }

    public static function create(string $title, string $body, User $author): self
    {
        $post = new self(Uuid::v4(), $title, $body, new \DateTimeImmutable('now'), $author);
        $post->record(new PostWasCreated($post));

        return $post;
    }

    public function id(): Uuid
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
     * @return array<string, array<string, int|string>|\DateTimeImmutable|string>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->toRfc4122(),
            'title' => $this->title(),
            'body' => $this->body(),
            'createdAt' => $this->createdAt(),
            'author' => $this->author->jsonSerialize(),
        ];
    }
}
