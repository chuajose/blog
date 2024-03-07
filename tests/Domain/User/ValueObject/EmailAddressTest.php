<?php

declare(strict_types=1);

namespace App\Tests\Domain\User\ValueObject;

use App\Domain\User\ValueObject\EmailAddress;

class EmailAddressTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateEmailAddressWithInvalidEmailReturnException(): void
    {
        $email = 'dsfasfd';
        $this->expectException(\InvalidArgumentException::class);
        new EmailAddress($email);
    }

    public function testCreateEmailAddressWithoutExtensionReturnException(): void
    {
        $email = 'dsfasfd@dfasdfas';
        $this->expectException(\InvalidArgumentException::class);
        new EmailAddress($email);
    }

    public function testCreateEmailAddressWithValidEmailReturnEmailAddress(): void
    {
        $email = 'example@example.com';
        $emailAddress = new EmailAddress($email);
        $this->assertInstanceOf(EmailAddress::class, $emailAddress);
        $this->assertSame($email, $emailAddress->value());
    }

    public function testCreateEmailAddressStaticMethod(): void
    {
        $email = 'example@example.com';
        $emailAddress = EmailAddress::fromString($email);
        $this->assertInstanceOf(EmailAddress::class, $emailAddress);
        $this->assertSame($email, $emailAddress->value());
    }
}
