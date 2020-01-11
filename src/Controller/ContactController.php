<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController{
    
    
    /**  
    * @Route("/contacts", name="contacts")
    */
    public function index() {
        return $this->render('contacts.html.twig');
    }
}
