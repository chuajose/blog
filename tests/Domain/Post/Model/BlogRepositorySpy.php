<?php

declare(strict_types=1);

namespace App\Tests\Domain\Post\Model;

use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use App\Domain\Blog\Model\PostCollection;
use App\Domain\Shared\Criteria\Criteria;
use Symfony\Component\Uid\Uuid;

class BlogRepositorySpy implements BlogRepository
{
    private ?Post $post = null;

    public function all(Criteria $criteria): PostCollection
    {
        return new PostCollection([$this->post], 1);
    }

    public function find(Uuid $id): ?Post
    {
        return $this->post;
    }

    public function create(Post $post): void
    {
        $this->post = $post;
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
}
