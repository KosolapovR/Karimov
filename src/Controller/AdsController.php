<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Ad;


class AdsController extends AbstractController{
    
    /**
     * @Route("/ads", name="ads")
     */
    public function index(){
        
        $em = $this->getDoctrine()->getManager();
        $ads = $em->getRepository(Ad::class)->findBy(['enabled' => true]);
        
        return $this->render('ads.html.twig', ['ads' => $ads]);
    }   
}