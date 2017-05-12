<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookChatBotController extends ChatBotController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->chatbotId = 'FB';
    }

    /**
     * Response to Facebook Chatbot Challenge request
     * @param Request request
     *
     * @return long|string challenge number if verified or error message if verification was failed.
     */
    public function responseChatBotChallengeAction(Request $request)
    {
        $challenge = $request->input('hub_challenge');
        if (null !== $challenge && $request->input('hub_mode') == 'subscribe' && $request->input('hub_verify_token') === env('CHATBOT_' . $this->chatbotId . '_VERIFY_TOKEN')) {
            return response($challenge, 200);
        }
        return response('You are not authorized', 403);
    }
}
