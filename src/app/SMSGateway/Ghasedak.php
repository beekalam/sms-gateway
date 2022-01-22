<?php

namespace App\SMSGateway;

use App\SMSGateway\SMSAdapter;
use Ghasedak\GhasedakApi;
use Ghasedak\Exceptions\ApiException;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Support\Facades\Log;

class Ghasedak implements SMSAdapter
{
    public const SMS_PROVIDER_NAME = "GHASEDAK";

    private string $apikey;
    private string $sender;

    public function __construct(string $sender, string $apikey)
    {
        $this->apikey = $apikey;
        $this->sender = $sender;
        Log::info("apikey: $apikey");
        Log::info("sender: $apikey");
    }

    public function sendMessage(SMSMessage $smsMessage)
    {

        $result = [];
        $success = false;
        try {
            $api = new GhasedakApi($this->apikey);
            $receptor = array($smsMessage->getMobile());
            $success = true;
            $result = $api->SendSimple($smsMessage->getMobile(), $smsMessage->getMessage(), "10008566");
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
