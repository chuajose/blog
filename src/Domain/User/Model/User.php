<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

class User implements \JsonSerializable
{
    private int $id;
    private string $name;
    private string $email;

    private function __construct(int $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public static function create(string $name, string $email): self
    {
        return new self(0, $name, $email);
    }

    public function id(): int
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
