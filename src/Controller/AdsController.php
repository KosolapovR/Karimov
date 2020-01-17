<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Event\MessageSendEvent;
use App\Form\MessageType;
use App\Form\AdsSortType;
use App\Entity\Ad;
use App\Entity\Product;
use App\Entity\Message;

class AdsController extends AbstractController{
    
    /**
     * @Route("/ads", name="ads")
     */
    public function index(Request $request){
        $form = $this->createForm(AdsSortType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $ads = $em->getRepository(Ad::class)
                    ->sortingAds(
                            $data['pattern'],
                            $data['onlyImg'],
                            $data['min_price'],
                            $data['max_price']);
            
            return $this->render('ads.html.twig', [
                    'ads' => $ads,
                    'adsSortForm' => $form->createView()
               ]);
        }
        $em = $this->getDoctrine()->getManager();
        $ads = $em->getRepository(Ad::class)->findBy(['enabled' => true]);
        
        return $this->render('ads.html.twig', [
                    'ads' => $ads,
                    'adsSortForm' => $form->createView()
               ]);
    } 
    
    /**
     * @Route("/ads/show/{id}", name="ad_show")
     */
    public function show(Ad $ad, Request $request, EventDispatcherInterface $eventDispatcherInterface)
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
                $products = $em->getRepository(Product::class)->findBy(['enabled' => true], ['dateAt' => 'DESC'], 4);
                return $this->render('index.html.twig', ['products' => $products]);
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