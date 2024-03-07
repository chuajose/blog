<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controllers\Blog;

use App\Application\Blog\ListPostUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListPostController extends AbstractController
{

    public function __construct(private readonly ListPostUseCase $listPostUseCase)
    {
    }

    #[Route('/v1/blog', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        $posts = $this->listPostUseCase->execute();

        return $this->json($posts->getIterator());
    }
}
