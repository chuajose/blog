<?php

declare(strict_types=1);

namespace App\Application\Blog\Dto;

readonly class PostDto
{
    public function __construct(
        private string $title,
        private string $body,
    ) {
    }

    public static function create(string $title, string $body): self
    {
        return new self(
            $title,
            $body,
        );
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }
}
