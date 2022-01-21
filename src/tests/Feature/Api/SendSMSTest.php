<?php

namespace Tests\Feature\Api;

use App\Jobs\SendMessage;
use App\Models\SMSLog;
use App\SMSGateway\Ghasedak;
use App\SMSGateway\Kavenegar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendSMSTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_sms_with_kavenegar()
    {
        $this->mockKavenegar();

        $response =  $this->postJson('/api/v1/send', [
            'mobile' => '09359012419',
            'message' => 'test'
        ]);

        $response->assertOk();
    }

    public function test_send_sms_with_ghasedak()
    {
        $this->mockGhasedak();
        $response =  $this->postJson('/api/v1/send', [
            'mobile' => '09359012419',
            'message' => 'test'
        ]);

        $response->assertOk();
    }

    private function send(array $payload)
    {
        return $this->mockKavenegar()->postJson('/api/v1/send', $payload);
    }

    public function test_mobile_number_is_required_for_sending_sms()
    {
        $response = $this->send([
            'message' => 'message'
        ]);
        $response->assertUnprocessable();
    }

    public function test_message_is_required_for_sending_sms()
    {
        $response = $this->send([
            'mobile' => '09359012419',
        ]);
        $response->assertUnprocessable();
    }

    public function test_a_valid_mobile_number_is_required_for_sending_sms()
    {
        $response = $this->send([
            'mobile' => '123',
            'message' => 'test'
        ]);

        $response->assertUnprocessable();
    }

    public function test_job_should_not_be_dispatched_when_inputs_are_not_valid()
    {
        $this->doesntExpectJobs(SendMessage::class);
        $this->send(['mobile' => '112']);
    }

    public function test_message_job_is_dispatched()
    {
        $this->mockKavenegar();
        $this->expectsJobs(SendMessage::class);
        $this->send([
            'mobile' => '09359012419',
            'message' => 'message'
        ]);
    }

    public function test_message_job_is_dispatched_when_using_ghasedak_as_sms_provider()
    {
        $this->mockGhasedak();
        $this->expectsJobs(SendMessage::class);
        $this->send([
            'mobile' => '09359012419',
            'message' => 'message'
        ]);
    }


    public function test_should_save_a_log_when_sms_has_been_sent()
    {
        $this->mockKavenegar();
        $this->send([
            'mobile' => '09359012419',
            'message' => 'message'
        ]);

        $this->assertDatabaseHas('sms_logs', [
            'mobile' => '09359012419',
            'message' => 'message',
            'sms_provider' => Kavenegar::SMS_PROVIDER_NAME,
            'sender' => '1001'
        ]);
    }

    public function test_should_save_correct_provider_name_and_sender_when_using_ghasedak()
    {
        $this->mockGhasedak();
        $this->postJson('/api/v1/send', [
            'mobile' => '09359012419',
            'message' => 'message'
        ]);

        $this->assertDatabaseHas('sms_logs', [
            'sms_provider' => Ghasedak::SMS_PROVIDER_NAME,
            'sender' => '1000'
        ]);
    }
}
