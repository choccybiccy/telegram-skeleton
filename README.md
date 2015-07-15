# Telegram Bot Skeleton App

Build bots in half the time.

## Requirements
* PHP 5.6
* [cURL](http://php.net/manual/en/book.curl.php)
* [Composer](https://getcomposer.org/)

## Getting started
To get started, simply clone this repository and install via composer.

    git clone http://github.com/choccybiccy/telegram-skeleton
    cd telegram-skeleton
    composer install

## Creating commands
See [choccybiccy/telegrambot#Creating commands](https://github.com/choccybiccy/telegrambot#creating-commands) for
help on creating commands.

## Installing the webhook
To tell the Telegram API of your new webhook, you should POST to https://<domain>/install.

For example:

    POST https://hellobot.choccybiccy.com/install HTTP/1.1
    
## Uninstalling the webhook
To remove the webhook from the Telegram API, you should POST to https://<domain>/uninstall

For example:

    POST https://hellobot.choccybiccy.com/uninstall HTTP/1.1
    
## Further reading
* [telegrambot](https://github.com/choccybiccy/telegrambot)
* [Telegram Bots](https://telegram.org/blog/bot-revolution)
* [Telegram Bots for developers](https://core.telegram.org/bots/api)

## Acknowledgements
* [Telegram](https://telegram.org/)
* [Slim PHP Framework](http://www.slimframework.com/)
