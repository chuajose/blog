<?php

declare(strict_types=1);

namespace App\Domain\Blog;

use App\Domain\Blog\Model\Post;
use App\Domain\Blog\Model\PostCollection;

interface BlogRepository
{
    public function all(): PostCollection;

    public function find(int $id): ?Post;

    public function create(Post $post): void;

    public function delete(int $id): void;
}
