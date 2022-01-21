<?php

namespace Tests\Feature;

use App\SMSGateway\Ghasedak;
use App\SMSGateway\Kavenegar;
use App\SMSGateway\SMSAdapter;
use Illuminate\Support\Env;
use InvalidArgumentException;
use Tests\TestCase;

class ContainerBindingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_send_sms()
    {
        $sms = app(SMSAdapter::class);
        $this->assertEquals($sms::class, Kavenegar::class);
    }

    public function test_config()
    {
        Env::getRepository()->set('SMS_PROVIDER', Ghasedak::SMS_PROVIDER_NAME);

        $sms = app(SMSAdapter::class);

        $this->assertEquals($sms::class, Ghasedak::class);
    }

    public function test_should_throw_when_no_sms_provider_is_set()
    {
        $this->expectException(InvalidArgumentException::class);

        Env::getRepository()->set('SMS_PROVIDER', '');

        app(SMSAdapter::class);
    }
}
