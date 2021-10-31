<?php

namespace App\MessageHandler;



use App\Message\RemoveProjectDocMessage;

class RemoveProjectDocMessageHandler implements MessageHandlerInterface
{

    public function __invoke(RemoveProjectDocMessage $message)
    {
        $filename = $message->getFilename();
    }
}