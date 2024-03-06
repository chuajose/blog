<?php declare(strict_types=1);

namespace App\Application\Blog;

use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\PostCollection;

class ListPostUseCase
{
    private BlogRepository $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function execute(): PostCollection
    {
        return $this->blogRepository->all();
    }

}