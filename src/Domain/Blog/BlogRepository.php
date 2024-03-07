<?php

declare(strict_types=1);

namespace App\Domain\Blog;

use App\Domain\Blog\Model\Post;
use App\Domain\Blog\Model\PostCollection;
use App\Domain\Shared\Criteria\Criteria;
use Symfony\Component\Uid\Uuid;

interface BlogRepository
{
    public function all(Criteria $criteria): PostCollection;

    public function find(Uuid $id): ?Post;

    public function create(Post $post): void;

    public function delete(int $id): void;
}
