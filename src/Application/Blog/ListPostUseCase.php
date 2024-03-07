<?php

declare(strict_types=1);

namespace App\Application\Blog;

use App\Domain\Blog\BlogRepository;
use App\Domain\Blog\Model\PostCollection;
use App\Domain\Shared\Criteria\Criteria;

class ListPostUseCase
{
    private BlogRepository $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function execute(Criteria $criteria): PostCollection
    {
        return $this->blogRepository->all($criteria);
    }
}
