<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Response\Serializer;

use League\Fractal\Serializer\ArraySerializer as BaseArraySerializer;

/**
 * Prevents array data from being assigned to a 'data' element.
 */
class ArraySerializer extends BaseArraySerializer
{
    /**
     * @inheritDoc
     */
    public function collection($resourceKey, array $data): array
    {
        if (!$resourceKey) {
            return $data;
        }

        return [$resourceKey => $data];
    }

    /**
     * @inheritDoc
     */
    public function item($resourceKey, array $data): array
    {
        if (!$resourceKey) {
            return $data;
        }

        return [$resourceKey => $data];
    }
}
