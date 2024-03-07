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
            return (int) $this->requestStack->getCurrentRequest()->get('page');
        }

        return null;
    }

    public function getLimit(): ?int
    {
        if ($this->requestStack->getCurrentRequest() && $this->requestStack->getCurrentRequest()->get('limit')) {
            return (int) $this->requestStack->getCurrentRequest()->get('limit');
        }

        return null;
    }
}
