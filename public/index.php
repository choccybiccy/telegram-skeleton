<?php

namespace App;

use Choccybiccy\Telegram\ApiClient;
use Choccybiccy\Telegram\CommandHandler;
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
    $handler = new CommandHandler($app->telegram);
    $handler->run($update);

})->name("webhook");



/**
 * Install webhook with Telegram API. Uses the current url and "webhook" route.
 */
$app->post("/install", function () use ($app) {
    $url = $app->request()->getUrl() . $app->urlFor("webhook");
    $app->telegram->setWebhook($url);
});



/**
 * Uninstall the webhook by sending a blank URL
 */
$app->post("/uninstall", function () use ($app) {
    $app->telegram->setWebhook("");
});


$app->run();
