<?php

declare(strict_types=1);

namespace App\Tests\Application\Blog;

use App\Application\Blog\CreatePostUseCase;
use App\Application\Blog\Dto\PostDto;
use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class CreatePostUseCaseTest extends TestCase
{
    private BlogRepository $blogRepository;

    public function testCreatePostReturnPost(): void
    {
        $this->blogRepository->expects($this->once())->method('create');
        $dto = new PostDto('title', 'content');
        $useCase = new CreatePostUseCase($this->blogRepository);
        $useCase->execute($dto);
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->blogRepository = $this->createMock(BlogRepository::class);
    }
}
