<?php

declare(strict_types=1);

namespace App\Domain\Blog\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class PostValidation extends \Exception implements HttpExceptionInterface
{
    public function __construct(private readonly ConstraintViolationListInterface $violations)
    {
        parent::__construct('Post validation error', 422);
    }

    public function violations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }

    #[\Override]
    public function getStatusCode(): int
    {
        return 422;
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
