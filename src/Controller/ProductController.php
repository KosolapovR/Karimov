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
        if($product->getEnabled()){
            return $this->render('product.html.twig', [
            'product' => $product
        ]);
        }else{
            $em = $this->getDoctrine()->getManager();
            $products = $em->getRepository(Product::class)->findBy(['enabled' => true], ['dateAt' => 'DESC'], 4);
            return $this->render('index.html.twig', ['products' => $products]);
        }  
    }
}