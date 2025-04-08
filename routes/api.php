<?php

use Illuminate\Support\Facades\Route; // ✅ This is the missing line

use App\Http\Controllers\MetaWebhookController;
use App\Http\Controllers\ChatController;

Route::get('/meta/webhook', [MetaWebhookController::class, 'verify']);
Route::post('/meta/webhook', [MetaWebhookController::class, 'handle']);

Route::get('/chat/users', [ChatController::class, 'users']);
Route::get('/chat/messages/{sender_id}', [ChatController::class, 'messages']);
Route::post('/chat/send', [ChatController::class, 'send']);
