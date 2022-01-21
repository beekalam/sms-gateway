<?php

namespace Tests\Feature;

use App\SMSGateway\SMSMessage;
use Tests\TestCase;
use App\SMSGateway\Ghasedak;

class GhasedakTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_should_send_message_when_correct_number_provided()
    {
        $this->mockGhasedak();

        $g = new Ghasedak("sender","apikey-123");

        list($success,  $result) = $g->sendMessage( new SMSMessage( "09359012419", "test_message"));

        $this->assertTrue($success);
    }

}
