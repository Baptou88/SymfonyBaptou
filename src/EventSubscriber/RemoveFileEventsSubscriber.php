<?php

namespace App\EventSubscriber;

use App\Message\RemoveProjectDocMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Event\Events;

class RemoveFileEventsSubscriber implements EventSubscriberInterface
{
    private $messageBus;

    /**
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::PRE_REMOVE =>['onPreRemove'],
        ] ;
    }

    public function onPreRemove(Event $event)
    {
        $mapping = $event->getMapping();
        $mappingName = $mapping->getMappingName();
        dump($mappingName);
        if ('project_doc' === $mappingName) {
            $this->dispatch(RemoveProjectDocMessage::class, $event);
        }
    }

    private function dispatch(string $messageClass, Event $event)
    {
        $event->cancel();

        $object = $event->getObject();

        $mapping = $event->getMapping();
        $filename = $mapping->getFileName($object);
        $message = new $messageClass($filename);
        $this->messageBus->dispatch($message);
    }

}