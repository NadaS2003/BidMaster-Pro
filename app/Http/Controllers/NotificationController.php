<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // لتحديد إشعار معين كمقروء عند الضغط عليه
    public function markAsRead($id) {
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        return back();
    }

// لتحديد كل الإشعارات كمقروءة بضغطة زر واحدة
    public function markAllAsRead() {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}
