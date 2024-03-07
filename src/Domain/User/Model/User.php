<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

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

    public static function create(string $name, string $email): self
    {
        return new self(Uuid::v4(), $name, $email);
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return array<string, string|int>
     */
    #[\Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->toRfc4122(),
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
