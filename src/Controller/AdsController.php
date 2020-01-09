<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Event\MessageSendEvent;
use App\Form\MessageType;
use App\Entity\Ad;
use App\Entity\Product;
use App\Entity\Message;
use App\Entity\User;

class AdsController extends AbstractController{
    
    /**
     * @Route("/ads", name="ads")
     */
    public function index(){
        $em = $this->getDoctrine()->getManager();
        $ads = $em->getRepository(Ad::class)->findBy(['enabled' => true]);
        
        return $this->render('ads.html.twig', ['ads' => $ads]);
    } 
    
    /**
     * @Route("/ads/show/{id}", name="ad_show")
     */
    public function show(
            Ad $ad,
            Request $request,
            EventDispatcherInterface $eventDispatcherInterface
            )
    {
        if($ad->getEnabled()){
            $message = new Message();
            $form = $this->createForm(MessageType::class, $message);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();

            if($form->isSubmitted() && $form->isValid()){
                $user = $ad->getUser();
                $user->__load();
                $message->setUser($user);
                $message->setAd($ad);            
                $em->persist($message);
                $em->flush();
                
                $event = new MessageSendEvent($message);
                $eventDispatcherInterface->dispatch(MessageSendEvent::NAME, $event);
            }
            
            return $this->render('ad.html.twig', [
            'product' => $ad,
            'messageForm' => $form->createView()
        ]);
        }else{
            $products = $em->getRepository(Product::class)->findBy(['enabled' => true], ['dateAt' => 'DESC'], 4);
            return $this->render('index.html.twig', ['products' => $products]);
        }
    }
}