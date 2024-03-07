<?php

declare(strict_types=1);

namespace App\Tests\UI\Http\Rest\Controllers\User;

use App\Application\User\ListUserUseCase;
use App\Domain\User\Model\User;
use App\Domain\User\Model\UserCollection;
use App\Domain\User\ValueObject\EmailAddress;
use App\UI\Http\Rest\Controllers\User\ListUserController;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ListUserControllerTest extends TestCase
{
    private ListUserController $controller;
    private ListUserUseCase $listUserUseCase;
    private const USER_NAME = 'jose';
    private const USER_EMAIL = 'exaple@example.com';

    /**
     * @throws \JsonException
     */
    public function testListUserReturnResponse(): void
    {
        $this->listUserUseCase->expects($this->once())->method('execute')->willReturn(new UserCollection([User::create(self::USER_NAME, EmailAddress::fromString(self::USER_EMAIL))], 1));
        $action = $this->controller->__invoke();
        $this->assertInstanceOf(JsonResponse::class, $action);
        $data = json_decode($action->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame(200, $action->getStatusCode());
        $this->assertIsArray($data);
        $this->assertArrayHasKey('items', $data);
        $this->assertArrayHasKey('total', $data);
        $this->assertIsArray($data['items']);
        $this->assertCount(1, $data['items']);
        $this->assertArrayHasKey('name', $data['items'][0]);
        $this->assertArrayHasKey('email', $data['items'][0]);
        $this->assertArrayHasKey('id', $data['items'][0]);
        $this->assertSame(self::USER_NAME, $data['items'][0]['name']);
        $this->assertSame(self::USER_EMAIL, $data['items'][0]['email']);
    }

    public function testListUsersWithoutUsersReturnResponse(): void
    {
        $this->listUserUseCase->expects($this->once())->method('execute')->willReturn(new UserCollection([], 0));
        $action = $this->controller->__invoke();
        $this->assertInstanceOf(JsonResponse::class, $action);
        $data = json_decode($action->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame(200, $action->getStatusCode());
        $this->assertIsArray($data);
        $this->assertArrayHasKey('items', $data);
        $this->assertArrayHasKey('total', $data);
        $this->assertIsArray($data['items']);
        $this->assertCount(0, $data['items']);
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $request = new RequestStack();
        $request->push(new Request(request: ['page' => 1, 'limit' => 10]));
        $this->listUserUseCase = $this->createMock(ListUserUseCase::class);
        $this->controller = new ListUserController(
            $this->listUserUseCase,
            $request
        );
    }
}
