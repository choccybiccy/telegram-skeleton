<?php

namespace App\Command;

use Choccybiccy\Telegram\Command;
use Choccybiccy\Telegram\Entity\Message;

/**
 * Class HelloWorldCommand
 * @package App\Command
 */
class HelloWorldCommand extends Command
{

    /**
     * Sends "Hello World" back to the initiating chat.
     *
     * @param string $argument
     * @param Message $message
     * @return void
     * @throws \Exception
     */
    protected function execute($argument, Message $message)
    {

        try {

            $this->getApiClient()->sendMessage($message->chat->id, "Hello World");

        } catch(\Exception $e) {
            throw new \Exception("Couldn't send the message.");
        }

    }
}
