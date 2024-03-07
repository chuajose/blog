<?php

declare(strict_types=1);

namespace App\Tests\UI\Http\Rest\Controllers\Blog;

use App\Application\Blog\CreatePostUseCase;
use App\Domain\Blog\Exception\PostValidation;
use App\Domain\User\Exception\UserNotFound;
use App\Domain\User\Model\User;
use App\Domain\User\UserRepository;
use App\Domain\User\ValueObject\EmailAddress;
use App\UI\Http\Rest\Controllers\Blog\CreatePostController;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CreatePostControllerTest extends TestCase
{
    private CreatePostController $controller;
    private UserRepository $userRepository;
    private const USER_ID = 'd1e7f3f4-3d3e-4f3b-8e3e-3f3d3e3f3d3e';
    private const USER_NAME = 'jose';
    private const USER_EMAIL = 'exaple@example.com';
    private const TITLE = 'Post Title';
    private const BODY = 'Post Body';

    /**
     * @throws UserNotFound
     * @throws PostValidation
     */
    public function testCreatePostReturnResponse(): void
    {
        $user = User::create(self::USER_NAME, EmailAddress::fromString(self::USER_EMAIL));
        $this->userRepository->expects($this->once())->method('find')->willReturn($user);
        $request = new Request(request: ['title' => self::TITLE, 'body' => self::BODY, 'user_id' => $user->id()->toRfc4122()]);
        $action = $this->controller->__invoke($request);
        $this->assertInstanceOf(JsonResponse::class, $action);
        $this->assertSame(201, $action->getStatusCode());
    }

    public function testCreatePostWithoutContentReturnValidationException(): void
    {
        $this->expectException(PostValidation::class);
        $user = User::create(self::USER_NAME, EmailAddress::fromString(self::USER_EMAIL));
        $request = new Request(request: ['title' => self::TITLE, 'user_id' => $user->id()->toRfc4122()]);
        $action = $this->controller->__invoke($request);
        $this->assertInstanceOf(JsonResponse::class, $action);
        $this->assertSame(201, $action->getStatusCode());
    }

    public function testCreatePostWithNotFoundUserReturnNotFoundException(): void
    {
        $this->expectException(UserNotFound::class);
        $this->userRepository->expects($this->once())->method('find')->willReturn(null);
        $request = new Request(request: ['title' => 'Your Title', 'body' => 'Your Body', 'user_id' => self::USER_ID]);
        $this->controller->__invoke($request);
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->controller = new CreatePostController(
            $this->createMock(CreatePostUseCase::class),
            $this->userRepository,
            $this->createMock(RequestStack::class)
        );
    }
}
