<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SMSLog;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view("dashboard");
    }

    public function report()
    {
        $reports = SMSLog::latest()->paginate();
        return view("reports.index",["reports" => $reports]);
    }
}
