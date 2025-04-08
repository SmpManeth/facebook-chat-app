<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Message;
use App\Services\FacebookService;



class MetaWebhookController extends Controller
{
    // STEP 1: Verifies the token from Meta Developer Portal
    public function verify(Request $request)
    {
        $verify_token = 'wordroids_verify_token'; // This must match what you enter in the Meta UI

        if (
            $request->has('hub_mode') &&
            $request->hub_mode === 'subscribe' &&
            $request->hub_verify_token === $verify_token
        ) {
            return response($request->hub_challenge, 200);
        }

        return response('Invalid verification token', 403);
    }

    // STEP 2: Handle Incoming Messages
    public function handle(Request $request, FacebookService $fb)

    {
        Log::info('🚨 Webhook handle method called!');
        $data = $request->all();

        if (isset($data['entry'][0]['messaging'][0])) {
            $messageData = $data['entry'][0]['messaging'][0];

            $senderId = $messageData['sender']['id'] ?? null;
            $recipientId = $messageData['recipient']['id'] ?? null;
            $text = $messageData['message']['text'] ?? null;

            Message::create([
                'sender_id' => $senderId,
                'recipient_id' => $recipientId,
                'message_text' => $text,
                'raw_payload' => json_encode($messageData), // ✅ Convert array to string
            ]);

            Log::info("✅ Message stored in database!");
            // ✅ Auto-reply when user sends message
            $fb->sendMessage($senderId, "Hi! Thanks for your message. We'll get back to you shortly Moda dave.");

            Log::info("✅ Message sent to user!");
        }

        return response('EVENT_RECEIVED', 200);
    }
}
