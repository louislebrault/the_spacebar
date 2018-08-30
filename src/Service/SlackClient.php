<?php

namespace App\Service;

use Nexy\Slack\Client;

class SlackClient
{

    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }

    public function sendMessage(string $from, string $message)
    {
        $slackMessage = $this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message)
        ;

        $this->slack->sendMessage($slackMessage);
    }
}