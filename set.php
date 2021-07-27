<?php
// Load composer
require __DIR__ . '/vendor/autoload.php';

use Schedule\Core\Settings;

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram(
        Settings::get('bot_api_key'), 
        Settings::get('bot_username'));

    // Set webhook
    $result = $telegram->setWebhook(Settings::get('hook_url'));

    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // log telegram errors
    echo $e->getMessage();
}