<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\User;

use App\Domain\Shared\Criteria\Criteria;
use App\Domain\User\Model\User;
use App\Domain\User\Model\UserCollection;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Uid\Uuid;

readonly class DoctrineOrmUserRepository implements UserRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param QueryBuilder $dql
     * @param int $page
     * @param int $limit
     * @return Paginator<User>
     */
    private function paginate(QueryBuilder $dql, int $page = 1, int $limit = 1): Paginator
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }

    public function all(Criteria $criteria): UserCollection
    {
        $query = $this->entityManager->createQueryBuilder();
        $query->select('u')
            ->from(User::class, 'u');

        $paginator = $this->paginate($query, $criteria->offset()??1, $criteria->limit()??10);
        return new UserCollection($paginator->getQuery()->getResult(), $paginator->count());
    }

    public function find(Uuid $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id->toRfc4122());
    }

    public function create(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}