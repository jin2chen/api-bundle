<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Controller;

use jin2chen\ApiBundle\Response\ResponseConverter;
use jin2chen\ApiBundle\Response\Type\CollectionType;
use jin2chen\ApiBundle\Response\Type\ObjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use function array_merge;

abstract class ApiController extends AbstractController
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedServices(): array
    {
        return array_merge(
            parent::getSubscribedServices(),
            [
                ResponseConverter::class,
            ]
        );
    }

    /**
     * @noinspection PhpIncompatibleReturnTypeInspection
     * @psalm-suppress all
     */
    protected function responseConverter(): ResponseConverter
    {
        return $this->get(ResponseConverter::class);
    }

    final protected function item(ObjectType $resource): JsonResponse
    {
        return $this->responseConverter()->toJson($resource);
    }

    final protected function collection(CollectionType $resource): JsonResponse
    {
        return $this->responseConverter()->toJson($resource);
    }
}
