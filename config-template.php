<?php

/**
 * Change this filename to config.php to connect it to project
 */

use Schedule\Core\Settings;
use Schedule\Core\DB\DbModel;

// Telegram Bot API
Settings::set('bot_api_key', '');

// Telegram Bot Username
Settings::set('bot_username', '');

// Telegram Bot url to your webhook
Settings::set('hook_url', '');

// Paths to telegram commands files
// Value must be an array type
Settings::set('command_paths', [
    __DIR__ . '/src/Commands'
]);

// MySQL Database configutation
Settings::set('mysql', [
    'host'      => 'localhost',
    'database'  => '',
    'user'      => '',
    'password'  => ''
]);

// Trello Account API Key
Settings::set('trello_api_key', '');

// Database Connection
Settings::set('mysql_connection', new DbModel(
    Settings::get('mysql')['host'],
    Settings::get('mysql')['database'],
    Settings::get('mysql')['user'],
    Settings::get('mysql')['password']
));