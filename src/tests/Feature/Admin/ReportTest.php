<?php

namespace Tests\Feature\Admin;

use App\Models\SMSLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_not_view_reports_page()
    {
        $this->get('/reports')->assertRedirect(route("login"));
    }

    public function test_logedin_users_can_view_reports()
    {
        $sms_log = SMSLog::factory()->create();
        $response = $this->actingAs(User::factory()->create())
            ->get(route('reports'));

        $response->assertOk();
        $response->assertSee($sms_log->mobile);
    }
}
