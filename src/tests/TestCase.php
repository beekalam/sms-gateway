<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery as m;
use Illuminate\Support\Env;
use App\SMSGateway\Ghasedak;
use App\SMSGateway\Kavenegar;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function mockKavenegar()
    {
        Env::getRepository()->set('SMS_PROVIDER', Kavenegar::SMS_PROVIDER_NAME);
        Env::getRepository()->set('KAVENEGAR_SENDER', '1001');

        /**@var $kavenegar_mock MockerInterface */
        $kavenegar_mock = m::mock('overload:Kavenegar\KavenegarApi');
        $kavenegar_mock->shouldReceive('Send')->andReturn([true, '', []]);

        return $this;
    }


    protected function mockGhasedak()
    {
        Env::getRepository()->set('SMS_PROVIDER', Ghasedak::SMS_PROVIDER_NAME);
        Env::getRepository()->set('GHASEDAK_SENDER', '1000');

        /**@var $ghasedak_mock MockerInterface */
        $ghasedak_mock = m::mock('overload:Ghasedak\GhasedakApi');
        $ghasedak_mock->shouldReceive('SendSimple')
            ->andReturn([true, '', []]);

        return $this;
    }
}
