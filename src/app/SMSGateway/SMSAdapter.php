<?php
namespace App\SMSGateway;

interface SMSAdapter
{
    public function sendMessage(SMSMessage $smsMessage);

    public function getSender();
}
