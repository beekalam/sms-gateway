<?php
namespace App\Exceptions;

use Exception;

class CredentialsException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
