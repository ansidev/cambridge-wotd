<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\ChatBot\Core\ChatBot;

class ChatBotController extends Controller
{
    /**
     * Chat Bot
     *
     * @var ChatBot
     */
    protected $chatbot;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ChatBot $chatbot)
    {
        $this->chatbot = $chatbot;
    }
}
