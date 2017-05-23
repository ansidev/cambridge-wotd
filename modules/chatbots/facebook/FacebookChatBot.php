<?php
namespace Modules\ChatBots\Facebook;

use Modules\ChatBots\Core\ChatBot;
class FacebookChatBot extends ChatBot {

    public function __construct()
    {
        $apiVersion = '2.6';
        $this->__construct('FB', $apiVersion, 'https://graph.facebook.com/v' . $apiVersion);
    }
}