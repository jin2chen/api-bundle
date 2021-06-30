<?php

namespace jin2chen\ApiBundle\Tests\App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController
{
    /**
     * @Route(path="/json")
     * @return Response
     */
    public function json(): Response
    {
        return new JsonResponse([]);
    }
}
