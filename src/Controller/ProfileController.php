<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ad;
use App\Form\NewAdType;
use App\Entity\Photo;

class ProfileController extends AbstractController{
    
    /**
     * @Route("/profile", name="profile")
     */
    public function index(){
        //dd($this->getParameter('app.path.ads_images'));
        //dd($this->getParameter('ads_images'));
        $em = $this->getDoctrine()->getManager();
        $ads = $em->getRepository(Ad::class)->findBy(['user' => $this->getUser()]);
        //$products = $em->getRepository(Product::class)->findAll();
        //$categories = $em->getRepository(Category::class)->findAll();
        
        return $this->render('profile.html.twig', [
                    'ads' => $ads
                ]);
    }
    
    /**
     * @Route("/profile/new", name="profile_new")
     */
    public function addNew(Request $request){
        $ad = new Ad();
        $form = $this->createForm(NewAdType::class, $ad);
        $form->handleRequest($request);
        $imageFile = $form['photos']->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                 
                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('app.path.ads_images'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $photo = new Photo();
                $photo->setImage($newFilename);
                $photo->setUpdatedAt(new \DateTime('now'));
                //$photo->setAd($ad);
                $ad->addPhoto($photo);
            }
            $ad->setDateAt(new \DateTime('now'));
            $ad->setUser($this->getUser());
            $ad->setEnabled(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($photo);
            $entityManager->persist($ad);
            
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('profile');
        }

        return $this->render('new_ad.html.twig', [
            'newAdForm' => $form->createView(),
        ]);
    }
}