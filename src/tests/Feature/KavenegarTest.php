<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\SMSGateway\Kavenegar;
use App\SMSGateway\SMSMessage;

class KavenegarTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    function test_should_send_message_when_correct_number_provided()
    {
        $this->mockKavenegar();

        $k = new Kavenegar("sendernumber", "10000");

        list($success, $result) = $k->sendMessage(new SMSMessage("09359012419", "test_message"));

        $this->assertTrue($success);
    }
}
