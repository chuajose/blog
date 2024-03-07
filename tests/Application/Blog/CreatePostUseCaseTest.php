<?php

declare(strict_types=1);

namespace App\Tests\Application\Blog;

use App\Application\Blog\CreatePostUseCase;
use App\Application\Blog\Dto\PostDto;
use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use App\Domain\Shared\Messenger\MessengerBusInterface;
use App\Domain\User\Model\User;
use App\Domain\User\ValueObject\EmailAddress;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class CreatePostUseCaseTest extends TestCase
{
    private BlogRepository $blogRepository;
    private MessengerBusInterface $messengerBus;

    public function testCreatePostReturnPost(): void
    {
        $this->blogRepository->expects($this->once())->method('create');
        $dto = new PostDto('title', 'content');
        $useCase = new CreatePostUseCase($this->blogRepository, $this->messengerBus);
        $useCase->execute($dto, User::create('jose', EmailAddress::fromString('jose@jose.com')));
    }

    public function testCreatePostLaunchEvent(): void
    {
        $this->messengerBus->expects($this->once())->method('dispatch');
        $this->blogRepository->expects($this->once())->method('create');
        $dto = new PostDto('title', 'content');
        $useCase = new CreatePostUseCase($this->blogRepository, $this->messengerBus);
        $useCase->execute($dto, User::create('jose', EmailAddress::fromString('jose@jose.com')));
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->messengerBus = $this->createMock(MessengerBusInterface::class);
        $this->blogRepository = $this->createMock(BlogRepository::class);
    }
}
