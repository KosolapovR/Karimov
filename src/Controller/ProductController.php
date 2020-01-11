<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use App\Event\MessageSendEvent;
use App\Form\MessageType;
use App\Entity\Product;
use App\Entity\Message;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ProductController extends AbstractController{
    
      /**
     * @Route("product/show/{id}", name="product_show")
     */
    public function show(
            Product $product,
            Request $request,
            EventDispatcherInterface $eventDispatcherInterface
            )
            {
        $em = $this->getDoctrine()->getManager();
        if($product->getEnabled()){
            $message = new Message();
            $form = $this->createForm(MessageType::class, $message);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $message->setUser($em->getRepository(\App\Entity\User::class)->find(6));
                $message->setProduct($product);            
                $em->persist($message);
                $em->flush();
                $event = new MessageSendEvent($message);
                $eventDispatcherInterface->dispatch(MessageSendEvent::NAME, $event);
                
                $products = $em->getRepository(Product::class)->findBy(['enabled' => true], ['dateAt' => 'DESC'], 4);
                return $this->render('index.html.twig', ['products' => $products]);
            }
            return $this->render('product.html.twig', [
            'product' => $product,
            'messageForm' => $form->createView(),
        ]);
        }else{
            $products = $em->getRepository(Product::class)->findBy(['enabled' => true], ['dateAt' => 'DESC'], 4);
            return $this->render('index.html.twig', ['products' => $products]);
        }  
    }
}