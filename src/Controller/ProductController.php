<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController{
    
    /**
     * @Route("/product{}", name="product")
     */
    public function index(){
        return $this->render('product.html.twig');
    }
}