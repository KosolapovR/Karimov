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
        if(null !== $sended_message->getProduct()){
            $product = $sended_message->getProduct()->getName();
        }elseif (null !== $sended_message->getAd()){
            $product = $sended_message->getAd()->getName();
        }
        $message = (new \Swift_Message)
                ->setSubject('Письмо по объявлению: ' . $product)
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
