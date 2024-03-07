<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Model\User;
use Symfony\Component\Uid\Uuid;

interface UserRepository
{

    public function find(Uuid $id): ?User;

    public function create(User $user): void;

    public function delete(int $id): void;
}
