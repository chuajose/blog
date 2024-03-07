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

    public function getPage():?int
    {
        return  (int)$this->requestStack->getCurrentRequest()?->get('page');
    }

    public function getLimit():?int
    {
       return  (int)$this->requestStack->getCurrentRequest()?->get('limit');

    }
}
