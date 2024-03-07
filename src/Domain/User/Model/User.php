<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use App\Domain\User\ValueObject\EmailAddress;
use Symfony\Component\Uid\Uuid;

class User implements \JsonSerializable
{
    private Uuid $id;
    private string $name;
    private string $email;

    private function __construct(Uuid $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public static function create(string $name, EmailAddress $email): self
    {
        return new self(Uuid::v4(), $name, $email->value());
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): EmailAddress
    {
        return EmailAddress::fromString($this->email);
    }

    /**
     * @return array<string, string|int>
     */
    #[\Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->toRfc4122(),
            'name' => $this->name(),
            'email' => $this->email()->value()
        ];
    }
}
