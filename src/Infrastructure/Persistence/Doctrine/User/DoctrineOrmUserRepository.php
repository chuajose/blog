<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\User;

use App\Domain\User\Model\User;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

readonly class DoctrineOrmUserRepository implements UserRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
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

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
}