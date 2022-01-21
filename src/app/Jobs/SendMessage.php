<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\SMSGateway\SMSAdapter;
use App\SMSGateway\SMSMessage;
use App\Models\SMSLog;
use Illuminate\Support\Facades\Log;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private SMSAdapter $smsAdapter;
    private SMSMessage $smsMessage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SMSAdapter $smsAdapter, SMSMessage $smsMessage)
    {
        $this->smsAdapter = $smsAdapter;
        $this->smsMessage = $smsMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        list($success, $result) = $this->smsAdapter->sendMessage($this->smsMessage);

        if ($success) {
            $res = SMSLog::create([
                'message' => $this->smsMessage->getMessage(),
                'mobile' => $this->smsMessage->getMobile(),
                'sms_provider' => $this->smsAdapter::SMS_PROVIDER_NAME,
                'sender' => $this->smsAdapter->getSender(),
            ]);
        } else {
            Log::info("Error sending SMS: ");
            Log::info($result);
        }
    }
}
