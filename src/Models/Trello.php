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
}