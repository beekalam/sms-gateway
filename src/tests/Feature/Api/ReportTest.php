<?php

namespace Tests\Feature\Api;

use App\Models\SMSLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_reports()
    {
        $smslog = SMSLog::factory()->create();

        $response = $this->getJson("/api/v1/report");

        $response->assertOk();

        $response->assertJsonFragment([
            'message' => $smslog->message,
            'sms_provider' => $smslog->sms_provider
        ]);
    }
}
