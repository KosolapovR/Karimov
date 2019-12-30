<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use App\Entity\Category;


class CatalogController extends AbstractController{
    
    /**
     * @Route("/catalog", name="catalog")
     */
    public function index(){
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('catalog.html.twig', [
            'products' => $products,
            'categories' => $categories,
                ]);
    }
    
    /**
     * @Route("/catalog/category/{id}", name="catalog_category") 
     */
    public function category(Category $category) {
        $em = $this->getDoctrine()->getManager();

        /** Category $category */
        $products = $category->getProducts();
        $categories = $em->getRepository(Category::class)->findAll();
      
        return $this->render('catalog.html.twig', [
            'products' => $products,
            'categories' => $categories,
                ]);
    }
}