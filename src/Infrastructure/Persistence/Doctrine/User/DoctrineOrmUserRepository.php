<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\User;

use App\Domain\User\Model\User;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class DoctrineOrmUserRepository implements UserRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function find(int $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
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