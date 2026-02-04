<?php

namespace App\Traits;

use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsAdminActivity
{
    protected function logActivity($action, $description)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminLog::create([
                'admin_id' => Auth::user()->user_id,
                'action' => $action,
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        }
    }
}