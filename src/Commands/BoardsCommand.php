<?php


namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Schedule\Models\Trello;

class BoardsCommand extends SystemCommand
{
    /**
    * @var string
    */
   protected $name = 'boards';

   /**
    * @var string
    */
   protected $description = 'Get all boards command';

   /**
    * @var string
    */
   protected $usage = '/boards';

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
        $userid = $message->getFrom()->getId();
        $firstname = $message->getFrom()->getFirstName();
        $lastname = $message->getFrom()->getLastName();

        try {
            $user_trello_key = Trello::getUserApiKey($userid);
        } catch(\Exception $e) {
            return Request::sendMessage([
                'chat_id' => $userid,
                'text' => 'Error!' . $e->getMessage()
            ]);
        }

        $trello = new Trello($user_trello_key );

        $boards = $trello->getBoardList();

        $result = '';

        foreach($boards as $board) {
            $result .= 'Name: ' . $board->name . PHP_EOL . 
                        'URL: ' . $board->url . PHP_EOL . 
                        'Id: ' . $board->id . PHP_EOL . PHP_EOL;
        }

        return Request::sendMessage([
            'chat_id' => $userid,
            'text' => "Your boards: " . PHP_EOL . $result
        ]);
   }
}