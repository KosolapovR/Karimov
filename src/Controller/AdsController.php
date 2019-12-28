<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdsController extends AbstractController{
    
    /**
     * @Route("/ads", name="ads")
     */
    public function index(){
        return $this->render('ads.html.twig');
    }   
}