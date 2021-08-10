<?php

namespace jin2chen\ApiBundle\Tests\App\Controller;

use ErrorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function toJson(Request $request): Response
    {
        return new JsonResponse($request->request->all());
    }

    public function exception(): void
    {
        throw new ErrorException('Service Unavailable.');
    }

    public function httpException(): void
    {
        throw new NotFoundHttpException('Not Found.');
    }
}
