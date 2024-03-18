<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controllers\Blog;

use App\Application\Blog\ListPostUseCase;
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

class ListPostController extends BaseRestController
{
    public function __construct(private readonly ListPostUseCase $listPostUseCase, readonly RequestStack $request)
    {
        parent::__construct($request);
    }

    #[OA\Parameter(
        name: 'page',
        description: 'Page list',
        in: 'query',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(response: 200, description: 'List of posts',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'total', type: 'integer', example: 'Total of posts'),
                new OA\Property(property: 'items', type: 'array', items: new OA\Items(properties: [
                        new OA\Property(property: 'id', type: 'string', example: 'Post id'),
                        new OA\Property(property: 'title', type: 'string', example: 'The post title'),
                        new OA\Property(property: 'body', type: 'string', example: 'The post body'),
                        new OA\Property(property: 'author', type: 'array', items: new OA\Items(properties: [
                                new OA\Property(property: 'id', type: 'string', example: 'Author id'),
                                new OA\Property(property: 'name', type: 'string', example: 'The name of author'),
                                new OA\Property(property: 'email', type: 'string', example: 'The email of author'),
                            ],
                            type: 'object')
                        ),
                        new OA\Property(property: 'createdAt', type: 'datetime'),
                    ],
                    type: 'object')
                )],
            type: 'object'))]
    #[OA\Tag(name: 'Blog')]
    #[Route('/v1/blog', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        // TODO: Recoger los datos para el order del request
        $posts = $this->listPostUseCase->execute(new Criteria(new Order(new OrderBy('createdAt'), OrderType::ASC), $this->getPage(), $this->getLimit()));

        return new JsonResponse(['items' => $posts->getIterator(), 'total' => $posts->total()]);
    }
}
