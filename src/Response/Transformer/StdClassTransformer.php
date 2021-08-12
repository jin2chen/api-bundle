<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Response\Transformer;

use League\Fractal\TransformerAbstract;
use stdClass;

/**
 * Converts stdClass instances to array by casting to array.
 */
final class StdClassTransformer extends TransformerAbstract
{
    public function transform(stdClass $entity): array
    {
        return (array) $entity;
    }
}
