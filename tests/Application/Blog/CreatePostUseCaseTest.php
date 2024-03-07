<?php

declare(strict_types=1);

namespace App\Tests\Application\Blog;

use App\Application\Blog\CreatePostUseCase;
use App\Application\Blog\Dto\PostDto;
use App\Domain\Blog\BlogRepository;
use App\Domain\Shared\Messenger\MessengerBusInterface;
use App\Domain\User\Model\User;
use App\Domain\User\ValueObject\EmailAddress;
use App\Tests\Domain\Post\Model\BlogRepositorySpy;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CreatePostUseCaseTest extends TestCase
{
    private BlogRepositorySpy $blogRepository;
    private MessengerBusInterface $messengerBus;

    public function testCreatePostReturnPost(): void
    {

        $dto = new PostDto('title', 'content');
        $useCase = new CreatePostUseCase($this->blogRepository, $this->messengerBus);
        $useCase->execute($dto, User::create('jose', EmailAddress::fromString('jose@jose.com')));

        self::assertSame('title', $this->blogRepository->find(Uuid::v4())->title());
        self::assertSame('content', $this->blogRepository->find(Uuid::v4())->body());
        self::assertSame('jose', $this->blogRepository->find(Uuid::v4())->author()->name());


    }

    public function testCreatePostLaunchEvent(): void
    {
        $this->messengerBus->expects($this->once())->method('dispatch');
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
        $this->blogRepository = new BlogRepositorySpy();
    }
}
