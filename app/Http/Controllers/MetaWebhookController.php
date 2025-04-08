<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     public function handle(Request $request)
     {
         Log::info('🚨 handle() method hit!');
         Log::info('📥 Meta payload:', $request->all());
     
         return response('EVENT_RECEIVED', 200);
     }
     
}
