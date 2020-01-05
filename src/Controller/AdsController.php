<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Ad;
use App\Entity\Product;


class AdsController extends AbstractController{
    
    /**
     * @Route("/ads", name="ads")
     */
    public function index(){
        $em = $this->getDoctrine()->getManager();
        $ads = $em->getRepository(Ad::class)->findBy(['enabled' => true]);
        
        return $this->render('ads.html.twig', ['ads' => $ads]);
    } 
    
    /**
     * @Route("/ads/show/{id}", name="ad_show")
     */
    public function show(Ad $ad){
        if($ad->getEnabled()){
            return $this->render('ad.html.twig', [
            'product' => $ad
        ]);
        }else{
            $em = $this->getDoctrine()->getManager();
            $products = $em->getRepository(Product::class)->findBy(['enabled' => true], ['dateAt' => 'DESC'], 4);
            return $this->render('index.html.twig', ['products' => $products]);
        }
    }
}