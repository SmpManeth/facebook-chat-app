<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FacebookService
{
    public function sendMessage(string $recipientId, string $text): bool
    {
        $response = Http::withToken(config('services.facebook.page_token'))
            ->post(config('services.facebook.graph_url'), [
                'recipient' => [
                    'id' => $recipientId,
                ],
                'message' => [
                    'text' => $text,
                ],
                'messaging_type' => 'RESPONSE',
            ]);

        return $response->successful();
    }
}
