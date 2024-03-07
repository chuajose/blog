<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\Criteria\Criteria;
use App\Domain\User\Model\User;
use App\Domain\User\Model\UserCollection;
use Symfony\Component\Uid\Uuid;

interface UserRepository
{

    public function find(Uuid $id): ?User;

    public function all(Criteria $criteria): UserCollection;

    public function create(User $user): void;

}
