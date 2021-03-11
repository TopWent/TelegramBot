<?php
require_once "vendor/autoload.php";

use TelegramBot\Controller\CountryBotController;
use TelegramBot\Api\Client;
use TelegramBot\Api\Exception;

try {
    $bot = new Client('token');

    $bot->command('start', function ($message) use ($bot) {
        $massageBody = 'Приветствую, укажите страну на ЛАТИНИЦЕЙ на англ языке, чтобы начать! /country *russia*';
        $bot->sendMessage($message->getChat()->getId(), $massageBody);
    });

    $bot->command('country', function ($message) use ($bot) {
        $text = $message->getText();
        $param = str_replace('/country ', '', $text);
        if (!empty($param)) {
            $country = new CountryBotController(trim($message));
            $emodji = $country->getUnicode();
            $massageBody = $emodji . ' https://ru.wikipedia.org/wiki/' . $country->country;
        }
        $bot->sendMessage($message->getChat()->getId(), $massageBody);
    });

    $bot->run();

} catch (Exception $e) {
    $e->getMessage();
}