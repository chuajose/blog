<?php

declare(strict_types=1);

namespace App\Tests\Application\User;

use App\Application\User\ListUserUseCase;
use App\Domain\Shared\Criteria\Criteria;
use App\Domain\Shared\Criteria\Order;
use App\Domain\User\Model\UserCollection;
use App\Domain\User\UserRepository;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ListUserUseCaseTest extends TestCase
{
    private UserRepository $userRepository;

    public function testListUserReturnUserCollection(): void
    {
        $useCase = new ListUserUseCase($this->userRepository);
        $this->assertInstanceOf(UserCollection::class, $useCase->execute(new Criteria(Order::fromValues('id', 'desc'), null,null)));
    }

    public function testListUserUseCaseCallMethodAll(): void
    {
        $this->userRepository->expects($this->once())->method('all');
        $useCase = new ListUserUseCase($this->userRepository);
        $useCase->execute(new Criteria(Order::fromValues('id', 'desc'), null,null));
    }
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
    }
}
