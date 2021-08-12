<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Response\Transformer;

use League\Fractal\TransformerAbstract;

/**
 * If the element is an array, return as-is and do not transform. Allows directly
 * returning existing array data while still utilising the Fractal infrastructure.
 */
final class ArrayTransformer extends TransformerAbstract
{
    public function transform(array $entity): array
    {
        return $entity;
    }
}
