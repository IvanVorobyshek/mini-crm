<?php

namespace App\Exceptions;

use Exception;

class RateLimitExceededException extends Exception
{
    public function __construct() {
        parent::__construct("You can only submit one ticket per 24 hours", 429);
    }
}