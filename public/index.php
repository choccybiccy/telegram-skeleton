<?php

namespace App;

use Choccybiccy\Telegram\ApiClient;
use Choccybiccy\Telegram\CommandHandler;
use Choccybiccy\Telegram\Entity\Update;
use josegonzalez\Dotenv\Loader;
use Slim\Slim;

require_once "../vendor/autoload.php";

$loader = new Loader("../.env");
$loader->parse()->define();

$app = new Slim();
$app->telegram = function () {
    return new ApiClient(TELEGRAM_BOT_AUTH_TOKEN);
};

// Webhook endpoint for Telegram
$app->post("/webhook", function () use ($app) {

    $update = $app->telegram->entityFromBody($app->request->getBody(), new Update());
    $handler = new CommandHandler($app->telegram);
    $handler->run($update);

});

// Install the webhook with Telegram
$app->post("/install", function () use ($app) {

});

// Uninstall the webhook from Telegram
$app->post("/uninstall", function () use ($app) {
    $this->telegram->setWebhook("");
});

$app->run();