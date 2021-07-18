<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Response;

use Throwable;

/**
 * @psalm-type ExceptionResponseArray = array{
 *     status: int,
 *     code: int,
 *     message: string,
 *     errors?: array
 * }
 */
interface ExceptionConverterInterface
{
    /**
     * Convert the exception to an array of message parameters.
     *  * status - the HTTP status code
     *  * code - error code or business code
     *  * message - the error message to display
     *  * errors - an array of key -> value pairs of error data (optional)
     *
     * @param Throwable $e
     *
     * @return ExceptionResponseArray
     */
    public function convert(Throwable $e): array;
}
