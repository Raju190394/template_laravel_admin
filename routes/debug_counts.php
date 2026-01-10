<?php

use Illuminate\Support\Facades\Route;
use App\Models\InternalMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/debug-counts', function () {
    $user = Auth::user();
    if (!$user) return 'Not logged in';
    
    return [
        'user_id' => $user->id,
        'user_role' => $user->role,
        'total_messages' => InternalMessage::count(),
        'my_inbox_count' => InternalMessage::inbox($user->id)->count(),
        'my_unread_count' => InternalMessage::inbox($user->id)->whereNull('read_at')->count(),
        'last_5_unread' => InternalMessage::inbox($user->id)->whereNull('read_at')->latest()->take(5)->pluck('id', 'subject'),
        'total_users' => User::count(),
        'users_roles' => User::pluck('role', 'id'),
    ];
});
