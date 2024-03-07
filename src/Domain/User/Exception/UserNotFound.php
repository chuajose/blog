<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class UserNotFound extends \Exception implements HttpExceptionInterface
{
    public function __construct(int $id)
    {
        parent::__construct("User with id: $id not found", 404);
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
