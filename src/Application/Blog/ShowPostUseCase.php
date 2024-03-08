<?php

declare(strict_types=1);

namespace App\Application\Blog;

use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use Symfony\Component\Uid\Uuid;

class ShowPostUseCase
{
    public function __construct(private readonly BlogRepository $blogRepository)
    {
    }

    public function execute(Uuid $id): ?Post
    {
        return $this->blogRepository->find($id);
    }
}
