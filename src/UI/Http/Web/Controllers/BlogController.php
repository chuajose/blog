<?php

declare(strict_types=1);

namespace App\UI\Http\Web\Controllers;

use App\Application\Blog\ListPostUseCase;
use App\Domain\Shared\Criteria\Criteria;
use App\Domain\Shared\Criteria\Order;
use App\Domain\Shared\Criteria\OrderBy;
use App\Domain\Shared\Criteria\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    public function __construct(private readonly ListPostUseCase $listPostUseCase)
    {
    }

    #[Route('/blog/{page}', name: 'blog_list', requirements: ['page' => '\d+'])]
    public function __invoke(int $page = 1): Response
    {
        $limit = 10;
        $posts = $this->listPostUseCase->execute(new Criteria(new Order(new OrderBy('createdAt'), OrderType::ASC), $page, $limit));

        return $this->render('blog/list.html.twig', [
            'posts' => $posts->getIterator(),
            'total' => $posts->total(),
            'currentPage' => $page,
            'limit' => $limit,
            'totalPages' => ceil($posts->total() / $limit),
        ]);
    }
}
