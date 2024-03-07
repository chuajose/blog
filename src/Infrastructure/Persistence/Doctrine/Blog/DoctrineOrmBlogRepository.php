<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Blog;

use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\Post;
use App\Domain\Blog\Model\PostCollection;
use App\Domain\Shared\Criteria\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Uid\Uuid;

readonly class DoctrineOrmBlogRepository implements BlogRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param QueryBuilder $dql
     * @param int $page
     * @param int $limit
     * @return Paginator<Post>
     */
    private function paginate(QueryBuilder $dql, int $page = 1, int $limit = 1): Paginator
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }

   public function all(Criteria $criteria): PostCollection
    {
        $query = $this->entityManager->createQueryBuilder();
        $query->select('p')
            ->from(Post::class, 'p');

        if($criteria->hasOrder()){
            $query->orderBy('p.'.$criteria->order()->orderBy()->value(), $criteria->order()->orderType()->value);
        }else{
            $query->orderBy('p.createdAt', 'DESC');
        }
        $paginator = $this->paginate($query, $criteria->offset()??1, $criteria->limit()??10);
        return new PostCollection($paginator->getQuery()->getResult(), $paginator->count());
    }

    public function find(Uuid $id): ?Post
    {
        return $this->entityManager->getRepository(Post::class)->find($id->toRfc4122());
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