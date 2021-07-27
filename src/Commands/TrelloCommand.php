<?php

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Schedule\Core\Settings;

class TrelloCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'trello';

    /**
     * @var string
     */
    protected $description = 'Trello integration';

    /**
     * @var string
     */
    protected $usage = '/trello <your_api_token>';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var bool
     */
    protected $private_only = false;

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        // If you use deep-linking, get the parameter like this:
        // $deep_linking_parameter = $this->getMessage()->getText(true);
        $message = $this->getMessage();
        $text = $message->getText();
        $userid = $message->getFrom()->getId();
        $cmds = explode(' ', $text);

        if(isset($cmds[1])) {
            // Set trello token
            try {
                $sql = 'INSERT INTO `users_trello_tokens`(`user_id`, `trello_token`) VALUES (:user, :trello)';
                Settings::get('mysql_connection')->dbQuery($sql, [
                    'user' => $userid,
                    'trello' => $cmds[1]
                ]);
            } catch(\Exception $e) {
                try {
                    $sql = 'UPDATE `users_trello_tokens` SET `trello_token`=:trello WHERE `user_id`=:user ';
                    Settings::get('mysql_connection')->dbQuery($sql, [
                        'user' => $userid,
                        'trello' => $cmds[1]
                    ]);
                } catch(\Exception $e) {
                    return Request::sendMessage([
                        'chat_id' => $userid,
                        'text' => 'Error! Cannot add or update token - ' . $cmds[1]
                    ]);
                }
            }

            return Request::sendMessage([
                'chat_id' => $userid,
                'text' => 'Success! Your token is - ' . $cmds[1]
            ]);
        } 

        return Request::sendMessage([
            'chat_id' => $userid,
            'text' => 'To authorize your Trello account follow this link: ' . PHP_EOL . 
                    'https://trello.com/1/authorize?expiration=never&name=Schedule%20Bot&scope=read,write&response_type=token&key=' . Settings::get('trello_api_key') . PHP_EOL . 
                    'Allow Schedule Bot to read your trello boards. After that copy api token and send:' . PHP_EOL . 
                    '/' . $this->name .  ' your_token'  . PHP_EOL .
                    'For example:'  . PHP_EOL . '/' . $this->name . ' 7sds234a738b631bba6162c636cba646d6ab159b60984b'
        ]);
    }
}