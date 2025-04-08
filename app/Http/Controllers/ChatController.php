<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Services\FacebookService;

class ChatController extends Controller
{
    // 1. Get unique users (sender IDs)
    public function users()
    {
        $users = Message::select('sender_id')->distinct()->get();
        return response()->json($users);
    }

    // 2. Get chat messages for selected user
    public function messages($sender_id)
    {
        $messages = Message::where('sender_id', $sender_id)
                        ->orWhere('recipient_id', $sender_id)
                        ->orderBy('created_at')
                        ->get();
        return response()->json($messages);
    }

    // 3. Send a reply message via Facebook API
    public function send(Request $request, FacebookService $fb)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|string',
            'message' => 'required|string',
        ]);

        $success = $fb->sendMessage($validated['recipient_id'], $validated['message']);

        // Optional: Save the sent message too
        if ($success) {
            Message::create([
                'sender_id' => 'you', // internal indicator
                'recipient_id' => $validated['recipient_id'],
                'message_text' => $validated['message'],
                'raw_payload' => null,
            ]);
        }

        return response()->json(['success' => $success]);
    }
}
