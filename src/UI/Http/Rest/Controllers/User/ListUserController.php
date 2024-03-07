<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controllers\User;

use App\Application\User\ListUserUseCase;
use App\Domain\Shared\Criteria\Criteria;
use App\Domain\Shared\Criteria\Order;
use App\Domain\Shared\Criteria\OrderBy;
use App\Domain\Shared\Criteria\OrderType;
use App\UI\Http\Rest\Controllers\BaseRestController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListUserController extends BaseRestController
{
    public function __construct(private readonly ListUserUseCase $listUserUseCase, readonly RequestStack $request)
    {
        parent::__construct($request);
    }

    #[OA\Parameter(
        name: 'page',
        description: 'Page list',
        in: 'path',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(response: 200, description: 'List of users',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'total', type: 'integer', example: 'Total of users'),
                new OA\Property(property: 'items', type: 'array', items: new OA\Items(properties: [
                        new OA\Property(property: 'id', type: 'string', example: 'user id'),
                        new OA\Property(property: 'name', type: 'string', example: 'The user name'),
                        new OA\Property(property: 'email', type: 'string', example: 'The user emails'),
                    ],
                    type: 'object')
                )],
            type: 'object'))]
    #[OA\Tag(name: 'User')]
    #[Route('/v1/user', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        // TODO: Recoger los datos para el order del request
        $users = $this->listUserUseCase->execute(new Criteria(new Order(new OrderBy('createdAt'), OrderType::ASC), $this->getPage(), $this->getLimit()));

        return new JsonResponse(['items' => $users->getIterator(), 'total' => $users->total()]);
    }
}
