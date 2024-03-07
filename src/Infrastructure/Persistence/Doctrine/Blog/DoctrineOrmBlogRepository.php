<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Blog;

use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use App\Domain\Blog\Model\PostCollection;
use Doctrine\ORM\EntityManagerInterface;

readonly class DoctrineOrmBlogRepository implements BlogRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

   public function all(): PostCollection
    {
        return new PostCollection($this->entityManager->getRepository(Post::class)->findAll());
    }

    public function find(int $id): ?Post
    {
        return $this->entityManager->getRepository(Post::class)->find($id);
    }

    public function create(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function update(Post $post): void
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
}