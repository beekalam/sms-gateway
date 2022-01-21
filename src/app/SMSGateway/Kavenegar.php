<?php

namespace App\SMSGateway;

use Illuminate\Support\Facades\Log;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;

class Kavenegar implements SMSAdapter
{

    public const SMS_PROVIDER_NAME = "KAVENEGAR";

    /**
     * Sender prefix number
     * @see  https://kavenegar.com/rest.html
     * @var string
     */
    private string $sender;

    private string $apiKey;

    public function __construct(string $sender, string $apiKey)
    {
        $this->sender = $sender;
        $this->apiKey = $apiKey;

        Log::info("apikey: " . $this->apiKey);
        Log::info("sender: " . $this->sender);
    }

    /**
     * Send message
     *
     * @param SMSMessage $smsMessage
     * @return array
     */
    public function sendMessage(SMSMessage $smsMessage)
    {
        $result = [];
        $success = false;
        try {
            $api = new KavenegarApi($this->apiKey);
            $receptor = $smsMessage->getMobile();
            $success = true;
            $result = $api->Send($this->sender, $receptor, $smsMessage->getMessage());
            Log::info($result);
            return [$success,  $result];
        } catch (ApiException $e) {
            $success = false;
            throw new SMSException($e->getMessage());
        } catch (HttpException $e) {
            $success = false;
            throw new SMSException($e->getMessage());
        }
    }

    public function getSender()
    {
        return $this->sender ?? "";
    }
}
