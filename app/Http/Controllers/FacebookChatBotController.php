<?php

namespace App\Http\Controllers;

use App\Contracts\WotdService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FacebookChatBotController extends ChatBotController
{
    /**
     * Wotd Service
     *
     * @var WotdService
     */
    private $wotdService;

    /**
     * Response HTTP Status code
     *
     * @var int
     */
    private $httpStatusCode = 200;

    private $chatBotId = 'FB';

    /**
     * Constructor
     *
     * @param WotdService $wotdService
     */
    public function __construct(WotdService $wotdService)
    {
        $this->wotdService = $wotdService;
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
        if (null !== $challenge && $request->input('hub_mode') == 'subscribe' && $request->input('hub_verify_token') === env('CHATBOT_' . $this->chatBotId . '_VERIFY_TOKEN')) {
            return response($challenge, 200);
        }
        return response('You are not authorized', 403);
    }

    /**
     * Response to Facebook user message
     * @param Request request
     *
     * @return mixed Reponse for Facebook Chatbot
     */
    public function responseUserMessageAction(Request $request)
    {
        $messageObject = $request->all();
        if ($messageObject['object'] != 'page') {
            return response('Message must be sent from page', 403);
        }
        $entries = $messageObject['entry'];
        foreach ($entries as $entry) {
            $messaging = $entry['messaging'];
            foreach ($messaging as $message) {
                $senderId = $message['sender']['id'];
                $messageData = $message['message'];
                if (null !== $messageData) {
                    $messageText = $messageData['text'];
                    if (null !== $messageText) {
                        $replyMessage = $this->runCommand($messageText);
                        $this->sendReplyMessage($senderId, $replyMessage);
                        return $replyMessage;
                    }
                }
            }
        }
        return response("You 've sent me " . json_encode($request->all()));
    }

    /**
     * Run command
     *
     * @param string $command Command name
     * @return string Reply message
     */
    private function runCommand(string $command)
    {
        $supportedCommands = ['help', 'wotd'];
        switch ($command) {
            case 'wotd':
                $wotd = $this->wotdService->getWordOfTheDay();
                if (array_key_exists('error', $wotd) && array_key_exists('message', $wotd)) {
                    $httpStatusCode = 500;
                    return $wotd['message'];
                }
                return $wotd['url'];
            case 'help':
                return 'Supported commands: ' . implode(', ', $supportedCommands) . '.';
            default:
                return 'Unsupported command. ' . $this->runCommand('help');
        }
    }

    /**
     * Send reply message
     *
     * @param int $senderId ID of sender
     * @param string $replyMessage Reply message
     * @return void
     */
    private function sendReplyMessage(int $senderId, string $replyMessage)
    {
        $chatBotApiVersion = env('CHATBOT_FB_API_VERSION');
        $url = 'https://graph.facebook.com/v'. $chatBotApiVersion .'/me/messages';
        $client = new Client();
        $response = $client->post($url, [
            'query' => [
                'access_token' => env('CHATBOT_FB_PAGE_ACCESS_TOKEN')
            ],
            'json' => [
                'recipient' => ['id' => $senderId],
                'message' => ['text' => $replyMessage]
            ]
        ]);
    }
}
