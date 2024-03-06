<?php

declare(strict_types=1);

namespace App\Tests\Application\Blog;

use App\Application\Blog\ListPostUseCase;
use App\Application\Blog\ShowPostUseCase;
use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use App\Domain\Blog\Model\PostCollection;
use App\Domain\User\Model\User;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ShowPostUseCaseTest extends TestCase
{
    private BlogRepository $blogRepository;

    public function testShowPostByIdReturnPost(): void
    {
        $this->blogRepository->expects($this->once())->method('find')->willReturn(Post::create(1, 'title', 'content', User::create(1, 'name', 'email')));

        $useCase = new ShowPostUseCase($this->blogRepository);
        $this->assertInstanceOf(Post::class, $useCase->execute(1));
    }

    public function testShowPostByIdReturnNull(): void
    {
        $this->blogRepository->expects($this->once())->method('find')->willReturn(null);

        $useCase = new ShowPostUseCase($this->blogRepository);

        $this->assertNull($useCase->execute(1));
    }
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->blogRepository = $this->createMock(BlogRepository::class);
    }
}
