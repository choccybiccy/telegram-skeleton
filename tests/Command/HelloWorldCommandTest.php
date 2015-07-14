<?php

namespace App;

use App\Command\HelloWorldCommand;
use Choccybiccy\Telegram\Entity\Message;

/**
 * Class HelloWorldCommandTest
 * @package App
 */
class HelloWorldCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test Hello World command execution
     */
    public function testExecute()
    {

        $message = new Message(["chat" => ["id" => 1], "text" => "/hello"]);
        $apiClient = $this->getMock("Choccybiccy\\Telegram\\ApiClient", ["sendMessage"], ["authtoken"]);
        $apiClient->expects($this->once())
            ->method("sendMessage")
            ->with($message->chat->id, "Hello World");

        $command = new HelloWorldCommand("hello");
        $command->run("", $message, $apiClient);

    }
}
