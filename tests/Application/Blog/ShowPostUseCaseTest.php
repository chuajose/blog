<?php

declare(strict_types=1);

namespace App\Tests\Application\Blog;

use App\Application\Blog\ShowPostUseCase;
use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use App\Domain\User\Model\User;
use App\Domain\User\ValueObject\EmailAddress;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class ShowPostUseCaseTest extends TestCase
{
    private BlogRepository $blogRepository;

    public function testShowPostByIdReturnPost(): void
    {
        $this->blogRepository->expects($this->once())->method('find')->willReturn(Post::create('title', 'content', User::create('name', EmailAddress::fromString('email@email.com'))));

        $useCase = new ShowPostUseCase($this->blogRepository);

        $this->assertInstanceOf(Post::class, $useCase->execute(Uuid::v4()));
    }

    public function testShowPostByIdReturnNull(): void
    {
        $this->blogRepository->expects($this->once())->method('find')->willReturn(null);

        $useCase = new ShowPostUseCase($this->blogRepository);

        $this->assertNull($useCase->execute(Uuid::v4()));
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->blogRepository = $this->createMock(BlogRepository::class);
    }
}
