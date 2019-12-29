<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;


class ProductController extends AbstractController{
    
      /**
     * @Route("product/show/{id}", name="product_show")
     */
    public function show(Product $product){
        return $this->render('product.html.twig', [
            'product' => $product
        ]);
    }
}