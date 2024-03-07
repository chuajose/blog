<?php

declare(strict_types=1);

namespace App\Domain\Blog\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class PostNotFound extends \Exception implements HttpExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct("Post with id: $id not found", 404);
    }

    #[\Override]
    public function getStatusCode(): int
    {
        return 404;
    }

    /**
     * @return array<string, string>
     */
    #[\Override]
    public function getHeaders(): array
    {
        return [];
    }
}
