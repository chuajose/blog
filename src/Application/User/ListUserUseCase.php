<?php declare(strict_types=1);

namespace App\Application\User;

use App\Domain\Shared\Criteria\Criteria;
use App\Domain\User\Model\UserCollection;
use App\Domain\User\UserRepository;

class ListUserUseCase
{

    public function __construct(private UserRepository $userRepository)
    {

    }

    public function execute(Criteria $criteria): UserCollection
    {
        return $this->userRepository->all($criteria);
    }
}