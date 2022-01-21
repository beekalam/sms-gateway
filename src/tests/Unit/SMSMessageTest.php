<?php

namespace Tests\Unit;

use App\SMSGateway\SMSMessage;
use InvalidArgumentException;
use Tests\TestCase;

class SMSMessageTest extends TestCase
{
    public function test_should_throw_when_mobile_is_invalid()
    {
        $this->expectException(InvalidArgumentException::class);
        new SMSMessage("", "message");
    }

    public function test_should_throw_on_bad_mobile_number()
    {
        $this->expectException(\InvalidArgumentException::class);
        $mobile_number_with_missing_digit = '093590124';
        new SMSMessage($mobile_number_with_missing_digit, "message");
    }

    public function test_should_throw_on_empty_message()
    {
        $this->expectException(\InvalidArgumentException::class);
        new SMSMessage('09359012419', "");
    }
}
