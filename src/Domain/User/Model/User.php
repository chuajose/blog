<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

class User
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

    public static function create(int $id, string $name, string $email): self
    {
        return new self($id, $name, $email);
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

}