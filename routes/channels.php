<?php

// routes/channels.php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{senderId}', function ($user, $senderId) {
    return true; // later you can add auth
});
