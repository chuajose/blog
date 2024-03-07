<?php

declare(strict_types=1);

namespace App\UI\Http\Web\Controllers;

use App\Application\Blog\ListPostUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{

    public function __construct(private readonly ListPostUseCase $listPostUseCase)
    {
    }

    #[Route('/blog', name: 'blog_list')]
    public function __invoke(): Response
    {
        $posts = $this->listPostUseCase->execute();

        return $this->render('blog/list.html.twig', [
            'posts' => $posts->getIterator(),
        ]);
    }
}
