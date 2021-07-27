<?php

namespace Schedule\Models;

use Schedule\Core\Settings;


class Trello
{
    private $api_token = '';

    public function __construct(string $api_token)
    {
        $this->api_token = $api_token;
    }

    public function getBoardList()
    {   
        return \Unirest\Request::get('https://api.trello.com/1/members/me/boards', [], [
            'key' => Settings::get('trello_api_key'),
            'token' => $this->api_token
        ])->body;
    }

    public static function getUserApiKey(string $user_id) : string
    {
        $sql = 'SELECT `trello_token` FROM `users_trello_tokens` WHERE `user_id` = :user_id';

            $user = Settings::get('mysql_connection')->dbQuery($sql, [
                'user_id' => $user_id
            ])->fetch();

            if(!isset($user['trello_token'])) {
                throw new \Exception('Trello API Token for this user not exist');
            }

            return $user['trello_token'];
    }
}