<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CatalogController extends AbstractController{
    
    /**
     * @Route("/catalog", name="catalog")
     */
    public function index(){
        return $this->render('catalog.html.twig');
    }
}