<?php
// Load composer
require __DIR__ . '/vendor/autoload.php';

use Schedule\Core\Settings;

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram(
        Settings::get('bot_api_key'), 
        Settings::get('bot_username'));
    
    // Enable MySQL if required
    $telegram->enableMySql(Settings::get('mysql'));

    // Add commands paths containing your custom commands
    $telegram->addCommandsPaths(Settings::get('command_paths'));

    // Handle telegram webhook request
    $telegram->handle();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    // log telegram errors
    echo $e->getMessage();
}