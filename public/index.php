<?php

namespace App;

use App\Command\HelloWorldCommand;
use Choccybiccy\Telegram\ApiClient;
use Choccybiccy\Telegram\CommandHandler;
use Choccybiccy\Telegram\Entity\Message;
use Choccybiccy\Telegram\Entity\Update;
use josegonzalez\Dotenv\Loader;
use Slim\Slim;

require_once "../vendor/autoload.php";

// Load the .env file if it exists.
if(file_exists(__DIR__ . "/../.env")) {
    $loader = new Loader("../.env");
    $loader->parse()->define();
}

/**
 * Create and inject the ApiClient into the Slim app.
 */
$app = new Slim();
$app->telegram = function () {
    return new ApiClient(TELEGRAM_BOT_AUTH_TOKEN);
};


/**
 * Here's the endpoint where Telegram will send it's updates to. Register your
 * commands in the CommandHandler in here.
 */
$app->post("/webhook", function () use ($app) {

    /** @var Update $update */
    $update = $app->telegram->entityFromBody(
        $app->request->getBody(), new Update()
    );
    if($update->message instanceof Message) {
        try {

            // Register your commands here
            $handler = new CommandHandler($app->telegram);
            $handler->register(new HelloWorldCommand("hello"));
            $handler->run($update);


        } catch(\Exception $e) {
            echo $e->getMessage();
            $app->response()->setStatus(500);
        }
    } else {
        echo "Couldn't find the Message in the body.";
        $app->response()->setStatus(400);
    }
})->name("webhook");



/**
 * Install webhook with Telegram API. Uses the current url and "webhook" route.
 * POST to this URL to install your webhook with Telegram.
 *
 * Note: Telegram requires your webhooks to use HTTPS.
 *
 * For example:
 *
 * POST https://bot.mydomain.com/install HTTP/1.1
 */
$app->post("/install", function () use ($app) {
    $url = $app->request()->getUrl() . $app->urlFor("webhook");
    try {
        $app->telegram->setWebhook($url);
    } catch(\Exception $e) {
        echo "Couldn't set the webhook. Have you set the bot auth token correctly?";
        $app->response()->setStatus(403);
    }
});



/**
 * Uninstall the webhook by sending a blank URL. Post to this URL to uninstall
 * your webhook.
 *
 * For example:
 *
 * POST https://bot.mydomain.com/uninstall HTTP/1.1
 */
$app->post("/uninstall", function () use ($app) {
    try {
        $app->telegram->setWebhook("");
    } catch(\Exception $e) {
        echo "Couldn't set the webhook. Have you set the bot auth token correctly?";
        $app->response()->setStatus(403);
    }
});


$app->run();
