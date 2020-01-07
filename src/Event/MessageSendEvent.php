<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;
use App\Entity\Message;

class MessageSendEvent extends Event
{
    const NAME = 'message.send';

    private $sended_message;
    
    public function __construct(Message $message) {
        $this->sended_message = $message;
    }
    
    function getSended_message() {
        return $this->sended_message;
    }
}
