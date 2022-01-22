<?php

namespace App\Http\Controllers;

use App\Models\SMSLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view("dashboard", [
            'num_jobs' => Queue::size(),
            'sent_messages_count' => SMSLog::count()
        ]);
    }

    public function report()
    {
        $reports = SMSLog::latest()->paginate(10);
        return view("reports.index", ["reports" => $reports]);
    }

    public function changePassword()
    {
        return view('auth.change-password');
    }

    public function storePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'string', 'min:6'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->to("/dashboard");
    }
}
