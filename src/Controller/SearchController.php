<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;


class SearchController extends AbstractController{
    
    /**
     * @Route("/search", name="ajax_search")
     */
    public function searchAction(Request $request){
        $requestString = $request->get('text');
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findEntitiesByString($requestString);
                
    if(!$products) {
          $result['products']['error'] = "Товар не найден";
      } else {
          $result['products'] = $this->getRealEntities($products);
      }
      return new Response(json_encode($result));
    }
    public function getRealEntities($entities){
        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getName();
        }
        return $realEntities;
    }
}