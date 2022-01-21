<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Models\SMSLog;
use App\SMSGateway\SMSAdapter;
use App\SMSGateway\SMSMessage;
use Illuminate\Http\Request;

class SMSController extends Controller
{

    public function send(Request $request)
    {
        $request->validate([
            'mobile' => ["required", "regex:/^(0\d{10})|(\+\d{12})$/"],
            'message' => ["required"] //todo: max length
        ]);

        $message = new SendMessage(
            app(SMSAdapter::class),
            new SMSMessage(request('mobile'), request('message'))
        );

        dispatch($message);

        return response(['success' => true]);
    }

    public function report()
    {
        return SMSLog::latest()->paginate();
    }
}
