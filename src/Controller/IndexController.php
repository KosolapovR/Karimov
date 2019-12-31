<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;


class IndexController extends AbstractController{
    
    /**
     * @Route("/", name="main")
     */
    public function index(){
        
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findBy(['enabled' => true], ['dateAt' => 'DESC'], 4);
        return $this->render('index.html.twig', ['products' => $products]);
    }
}