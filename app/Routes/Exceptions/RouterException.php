<?php

namespace App\Routes\Exceptions;

use Exception;

/**
 * Custom exception class for router-specific errors.
 * This helps in distinguishing routing issues (e.g., 404, 405) from other
 * application exceptions and allows for a clean error handling flow.
 */
class RouterException extends Exception
{
}
