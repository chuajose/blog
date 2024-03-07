<?php

declare(strict_types=1);

namespace App\Tests\UI\Http\Rest\Controllers\Blog;

use App\Application\Blog\ListPostUseCase;
use App\Domain\Blog\Model\Post;
use App\Domain\Blog\Model\PostCollection;
use App\Domain\User\Model\User;
use App\Domain\User\ValueObject\EmailAddress;
use App\UI\Http\Rest\Controllers\Blog\ListPostController;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class ListPostControllerTest extends TestCase
{
    private ListPostController $controller;
    private ListPostUseCase $listPostUseCase;
    private const USER_NAME = 'jose';
    private const USER_EMAIL = 'exaple@example.com';
    private const TITLE = 'Post Title';
    private const BODY = 'Post Body';

    /**
     * @throws \JsonException
     */
    public function testListPostReturnResponse(): void
    {
        $user = User::create(self::USER_NAME, EmailAddress::fromString(self::USER_EMAIL));
        $this->listPostUseCase->expects($this->once())->method('execute')->willReturn(new PostCollection([Post::create(self::TITLE, self::BODY, $user)], 1));
        $action = $this->controller->__invoke();
        $this->assertInstanceOf(JsonResponse::class, $action);
        $data = json_decode($action->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame(200, $action->getStatusCode());
        $this->assertIsArray($data);
        $this->assertArrayHasKey('items', $data);
        $this->assertArrayHasKey('total', $data);
        $this->assertIsArray($data['items']);
        $this->assertCount(1, $data['items']);
        $this->assertArrayHasKey('title', $data['items'][0]);
        $this->assertArrayHasKey('body', $data['items'][0]);
        $this->assertArrayHasKey('id', $data['items'][0]);
        $this->assertArrayHasKey('author', $data['items'][0]);
        $this->assertArrayHasKey('name', $data['items'][0]['author']);
        $this->assertArrayHasKey('email', $data['items'][0]['author']);
        $this->assertSame(self::USER_NAME, $data['items'][0]['author']['name']);
        $this->assertSame(self::USER_EMAIL, $data['items'][0]['author']['email']);
        $this->assertSame(self::TITLE, $data['items'][0]['title']);
        $this->assertSame(self::BODY, $data['items'][0]['body']);
    }

    public function testListPostWithoutPostsReturnResponse(): void
    {
        $this->listPostUseCase->expects($this->once())->method('execute')->willReturn(new PostCollection([], 0));
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
        $this->listPostUseCase = $this->createMock(ListPostUseCase::class);
        $this->controller = new ListPostController(
            $this->listPostUseCase,
            $this->createMock(RequestStack::class)
        );
    }
}
