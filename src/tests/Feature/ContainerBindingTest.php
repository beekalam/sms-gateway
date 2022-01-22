<?php

namespace Tests\Feature;

use App\Exceptions\CredentialsException;
use App\SMSGateway\Ghasedak;
use App\SMSGateway\Kavenegar;
use App\SMSGateway\SMSAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Env;
use Tests\TestCase;

class ContainerBindingTest extends TestCase
{
    use RefreshDatabase;


    public function test_container_can_instantiate_a_class()
    {
        $sms = app(SMSAdapter::class);
        $this->assertEquals($sms::class, Kavenegar::class);
    }

    public function test_container_can_instantiate_correct_class()
    {
        Env::getRepository()->set('SMS_PROVIDER', Ghasedak::SMS_PROVIDER_NAME);

        $sms = app(SMSAdapter::class);

        $this->assertEquals($sms::class, Ghasedak::class);
    }

    public function test_should_throw_when_no_sms_provider_is_set()
    {
        $this->expectException(CredentialsException::class);

        Env::getRepository()->clear('SMS_PROVIDER', '');

        app(SMSAdapter::class);
    }

    public function test_should_throw_when_ghasedak_provider_credentials_are_empty()
    {
        $this->expectException(CredentialsException::class);

        Env::getRepository()->set('SMS_PROVIDER', Ghasedak::SMS_PROVIDER_NAME);
        Env::getRepository()->set('GHASEDAK_API_KEY', '');

        app(SMSAdapter::class);
    }

    public function test_should_throw_when_kavenegar_provider_credentials_are_empty()
    {
        $this->expectException(CredentialsException::class);

        Env::getRepository()->set('SMS_PROVIDER', Kavenegar::SMS_PROVIDER_NAME);
        Env::getRepository()->set('KAVENEGAR_API_KEY', '');

        app(SMSAdapter::class);
    }

    public function test_when_credentials_is_not_provided_a_json_response_returned()
    {
        $this->mockKavenegar();
        Env::getRepository()->clear('SMS_PROVIDER', '');

        $response =  $this->postJson('/api/v1/send', [
            'mobile' => '09359012419',
            'message' => 'test'
        ]);
        $response->assertJson(['error' => 'SMS provider credentials is missing.']);
    }

    public function test_when_api_key_is_not_provided_a_json_response_is_returned()
    {

        $this->mockKavenegar();
        Env::getRepository()->clear('KAVENEGAR_API_KEY', '');

        $response =  $this->postJson('/api/v1/send', [
            'mobile' => '09359012419',
            'message' => 'test'
        ]);

        $response->assertJson(['error' => 'Apikey is not provided.']);
    }
}
