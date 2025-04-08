<?php

use Illuminate\Support\Facades\Route; // ✅ This is the missing line

use App\Http\Controllers\MetaWebhookController;

Route::get('/meta/webhook', [MetaWebhookController::class, 'verify']);
Route::post('/meta/webhook', [MetaWebhookController::class, 'handle']);
