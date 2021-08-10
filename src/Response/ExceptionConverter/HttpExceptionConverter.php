<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Response\ExceptionConverter;

use InvalidArgumentException;
use jin2chen\ApiBundle\Response\ExceptionConverterInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class HttpExceptionConverter implements ExceptionConverterInterface
{
    /**
     * @inheritdoc
     */
    public function convert(Throwable $e): array
    {
        if (!$e instanceof HttpException) {
            throw new InvalidArgumentException(sprintf('%s is not a %s', get_class($e), HttpException::class));
        }

        $statusCode = $e->getStatusCode();
        $message = 'Internal Service Error.';
        if ($statusCode < 400) {
            $statusCode = 500;
        } elseif ($statusCode >= 600) {
            $statusCode = 500;
        } else {
            $message = $e->getMessage();
        }

        return [
            'status' => $statusCode,
            'code' => (int) $e->getCode(),
            'message' => $message,
        ];
    }
}
