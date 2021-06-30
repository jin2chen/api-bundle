<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Response;

use League\Fractal\Resource\ResourceAbstract;

interface ResponseTypeInterface
{
    public function asResource(): ResourceAbstract;

    public function getIncludes(): string;

    public function getMeta(): array;
}
