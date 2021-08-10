<?php

namespace jin2chen\ApiBundle\Response\Type;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceAbstract;

class CollectionType extends AbstractType
{
    private iterable $resource;

    public function __construct(iterable $resource, string $transformer, array $meta = [], ?string $key = null)
    {
        $this->resource    = $resource;
        $this->transformer = $transformer;
        $this->key         = $key;
        $this->meta        = $meta;
    }

    public function asResource(): ResourceAbstract
    {
        $item = new Collection($this->resource, $this->transformer, $this->key);
        $item->setMeta($this->meta);

        return $item;
    }

    public function getResource(): iterable
    {
        return $this->resource;
    }
}
