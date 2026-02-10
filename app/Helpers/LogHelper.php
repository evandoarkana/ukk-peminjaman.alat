<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

class LogHelper
{
    public static function store($aktivitas, $deskripsi)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
            'deskripsi' => $deskripsi,
            'ip_address' => Request::ip(),
        ]);
    }
}