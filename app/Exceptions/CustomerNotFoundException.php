<?php

namespace App\Exceptions;

use Exception;

class CustomerNotFoundException extends Exception
{
    public function __construct(
        string $phone,
    ) {
        parent::__construct("Customer with phone {$phone} not found", 404);
    }
}