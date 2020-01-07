<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\MessageSendEvent;

class MessageSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig\Environment $twig) {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    
    public function onMessageSend(MessageSendEvent $event)
    {
        /* Message $sended_message */
        $sended_message = $event->getSended_message();
        $body = $this->twig->render('email_message.html.twig', ['message' => $sended_message]);
        $message = (new \Swift_Message)
                ->setSubject('Письмо по объявлению: ' . $sended_message->getProduct()->getName())
                ->setFrom($sended_message->getEmail())
                ->setTo($sended_message->getUser()->getEmail())
                ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }

    public static function getSubscribedEvents()
    {
        return [
        MessageSendEvent::NAME => 'onMessageSend',
        ];
    }
}
