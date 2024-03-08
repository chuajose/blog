<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class BaseRestController extends AbstractController
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getPage(): ?int
    {
        if ($this->requestStack->getCurrentRequest() && $this->requestStack->getCurrentRequest()->get('page')) {
            $page = $this->requestStack->getCurrentRequest()->get('page');
            if (is_string($page) || is_numeric($page)) {
                return (int) $page;
            }
        }

        return null;
    }

    public function getLimit(): ?int
    {
        if ($this->requestStack->getCurrentRequest() && $this->requestStack->getCurrentRequest()->get('limit')) {
            $limit = $this->requestStack->getCurrentRequest()->get('limit');
            if (is_string($limit) || is_numeric($limit)) {
                return (int) $limit;
            }
        }

        return null;
    }
}
