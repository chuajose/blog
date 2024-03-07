<?php

declare(strict_types=1);

namespace App\Tests\Application\Blog;

use App\Application\Blog\ListPostUseCase;
use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\PostCollection;
use App\Domain\Shared\Criteria\Criteria;
use App\Domain\Shared\Criteria\Order;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ListPostUseCaseTest extends TestCase
{
    private BlogRepository $blogRepository;

    public function testListPostReturnPostCollection(): void
    {
        $useCase = new ListPostUseCase($this->blogRepository);
        $this->assertInstanceOf(PostCollection::class, $useCase->execute(new Criteria(Order::fromValues('createdAt', 'desc'), null,null)));
    }

    public function testListPostUseCaseCallMethodAll(): void
    {
        $this->blogRepository->expects($this->once())->method('all');
        $useCase = new ListPostUseCase($this->blogRepository);
        $useCase->execute(new Criteria(Order::fromValues('createdAt', 'desc'), null,null));
    }
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->blogRepository = $this->createMock(BlogRepository::class);
    }
}
