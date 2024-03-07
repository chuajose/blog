<?php

declare( strict_types=1 );

namespace App\Domain\User\ValueObject;

use InvalidArgumentException;

final class EmailAddress {

    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct($email)
    {
        $email = strtolower($email);
        $this->disallowInvalidEmailAddress($email);
        $this->value = $email;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function disallowInvalidEmailAddress($email): void
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException('Email address is invalid');
        }
    }


    public static function fromString(string $email): EmailAddress
    {
        return new self($email);
    }

    public function value(): string
    {
        return $this->value;
    }
    public function __toString()
    {
        return $this->value;
    }

}
