<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controllers\Blog;

use App\Application\Blog\ListPostUseCase;
use App\Domain\Shared\Criteria\Criteria;
use App\Domain\Shared\Criteria\Order;
use App\Domain\Shared\Criteria\OrderBy;
use App\Domain\Shared\Criteria\OrderType;
use App\UI\Http\Rest\Controllers\BaseRestController;
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

    #[Route('/v1/blog', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        //TODO: Recoger los datos para el order del request
        $posts = $this->listPostUseCase->execute(new Criteria(new Order(new OrderBy('createdAt'), OrderType::ASC), $this->getPage(), $this->getLimit()));

        return $this->json(['items' => $posts->getIterator(), 'total' => $posts->total()]);
    }
}
