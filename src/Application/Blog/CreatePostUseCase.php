<?php

declare(strict_types=1);

namespace App\Application\Blog;

use App\Application\Blog\Dto\PostDto;
use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use App\Domain\User\Model\User;

readonly class CreatePostUseCase
{
    public function __construct(private BlogRepository $blogRepository)
    {
    }

    public function execute(PostDto $dto, User $user): void
    {
        $post = Post::create($dto->title(), $dto->body(), $user);
        $this->blogRepository->create($post);
    }
}
