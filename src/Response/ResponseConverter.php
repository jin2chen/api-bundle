<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Response;

use League\Fractal\Manager as Fractal;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\Serializer\SerializerAbstract as Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Stopwatch\Stopwatch;

use function implode;
use function sprintf;

use const JSON_UNESCAPED_UNICODE;

/**
 * Converts a response type to an appropriate response format.
 */
final class ResponseConverter
{
    private Fractal $fractal;
    private ?Stopwatch $stopwatch;

    public function __construct(Fractal $fractal, Serializer $serializer, Stopwatch $stopwatch = null)
    {
        $this->fractal = $fractal;
        $this->stopwatch = $stopwatch;

        $this->setSerializer($serializer);
    }

    public function setSerializer(Serializer $serializer): self
    {
        $this->fractal->setSerializer($serializer);

        return $this;
    }

    public function toArray(ResponseTypeInterface $type): array
    {
        $this->processIncludes($type);

        return $this->createData($type->asResource());
    }

    public function toJson(ResponseTypeInterface $type): JsonResponse
    {
        $resource = $type->asResource();

        $this->processIncludes($type);

        return $this->createResponse($resource, $this->createData($resource));
    }

    private function processIncludes(ResponseTypeInterface $type): void
    {
        $this->profile('fractal.process_includes', fn() => $this->fractal->parseIncludes($type->getIncludes()));
    }

    private function createData(ResourceAbstract $resource): array
    {
        return (array) $this->profile(
            'fractal.create_data_array',
            fn() => $this->fractal->createData($resource)->toArray()
        );
    }

    private function createResponse(ResourceAbstract $resource, array $data): JsonResponse
    {
        /** @var JsonResponse $response */
        $response = $this->profile(
            'fractal.create_json_response',
            fn() => (new JsonResponse($data))->setEncodingOptions(JSON_UNESCAPED_UNICODE)
        );

        if ($resource instanceof Collection && $resource->hasPaginator()) {
            $paginator = $resource->getPaginator();

            $header = [];
            if (($paginator->getCurrentPage() - 1) > 0) {
                $header[] = sprintf('%s; rel="previous"', $paginator->getUrl($paginator->getCurrentPage() - 1));
            }
            if (($paginator->getCurrentPage() + 1) <= $paginator->getLastPage()) {
                $header[] = sprintf('%s; rel="next"', $paginator->getUrl($paginator->getCurrentPage() + 1));
            }

            $response->headers->add(
                [
                    'X-API-Pagination-TotalResults' => $paginator->getTotal(),
                    'X-API-Pagination-Page' => $paginator->getCurrentPage(),
                    'X-API-Pagination-PageCount' => $paginator->getLastPage(),
                    'X-API-Pagination-PageResults' => $paginator->getCount(),
                    'X-API-Pagination-PageSize' => $paginator->getPerPage(),
                    'Link' => implode(', ', $header),
                ]
            );
        }

        return $response;
    }

    private function profile(string $segment, callable $callback): mixed
    {
        $this->start($segment);
        /** @var mixed $return */
        $return = $callback();
        $this->stop($segment);

        return $return;
    }

    private function start(string $name): void
    {
        if (!$this->stopwatch) {
            return;
        }

        $this->stopwatch->start($name);
    }

    private function stop(string $name): void
    {
        if (!$this->stopwatch) {
            return;
        }

        $this->stopwatch->stop($name);
    }
}
