<?php

declare(strict_types=1);

namespace App\Application\Blog;

use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use Symfony\Component\Uid\Uuid;

class ShowPostUseCase
{
    private BlogRepository $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function execute(Uuid $id): ?Post
    {
        return $this->blogRepository->find($id);
    }
}
