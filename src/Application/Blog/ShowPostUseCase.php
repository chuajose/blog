<?php

declare(strict_types=1);

namespace App\Application\Blog;

use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;

class ShowPostUseCase
{
    private BlogRepository $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function execute(int $id): ?Post
    {
        return $this->blogRepository->find($id);
    }
}