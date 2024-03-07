<?php

declare(strict_types=1);

namespace App\UI\Http\Web\Controllers;

use App\Application\Blog\ShowPostUseCase;
use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Exception\PostNotFound;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogShowController extends BaseController
{

    public function __construct(private readonly ShowPostUseCase $showPostUseCase)
    {
    }

    /**
     * @throws PostNotFound
     */
    #[Route('/blog/{id}', name: 'blog_show')]
    public function __invoke(int $id): Response
    {
        $post = $this->showPostUseCase->execute($id);

        if (!$post) {
            throw new PostNotFound($id);
        }

        return $this->render('blog/show.html.twig', ['post' => $post]);
    }
}
