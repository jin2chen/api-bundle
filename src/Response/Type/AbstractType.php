<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Response\Type;

use jin2chen\ApiBundle\Response\ResponseTypeInterface;
use League\Fractal\Resource\ResourceAbstract;

use function implode;
use function is_array;

abstract class AbstractType implements ResponseTypeInterface
{
    protected string $transformer;
    protected ?string $key;
    protected string $includes = '';
    protected array $meta = [];

    abstract public function asResource(): ResourceAbstract;

    public function withKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string|list<string> $includes
     *
     * @return $this
     */
    public function withIncludes(string|array $includes): static
    {
        $this->includes = is_array($includes) ? implode(',', $includes) : $includes;

        return $this;
    }

    public function withMeta(array $meta): static
    {
        $this->meta = $meta;

        return $this;
    }

    public function getTransformer(): string
    {
        return $this->transformer;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function getIncludes(): string
    {
        return $this->includes;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }
}
