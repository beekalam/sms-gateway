<?php

namespace App\SMSGateway;

use InvalidArgumentException;

class SMSMessage
{
    private string $mobile;
    private string $message;

    public function __construct(string $mobile, string $message)
    {
        /*
         * +989359012419 is accepted
         * +999359012419 is accepted
         * 09359012419 is accepted
         */
        $isValidNumber = preg_match(
            '/^(0\d{10})|(\+\d{12})$/',
            $mobile,
            $matches
        );

        if (!$isValidNumber)
            throw new InvalidArgumentException('Invalid mobile number');

        if (empty($message))
            throw new InvalidArgumentException("Message is empty");

        $this->mobile = $mobile;
        $this->message = $message;
    }

    public function getMobile()
    {
        return $this->mobile;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
