<?php

namespace App\SMSGateway;

use Exception;

class SMSException extends Exception
{
    public function __construct(string $message, int $code  = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
