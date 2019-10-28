<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="tricks")
     */
    public function index()
    {
        return $this->render('tricks/index.html.twig', [
            'controller_name' => 'TricksController',
            
        ]);
    }
    
    /**
     * @Route("/", name="home")
     */
    public function home(TrickRepository $repo)
    {

        $tricks = $repo->findAll();

        return $this->render('tricks/home.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/tricks/new" , name="trick_new")
     * @Route("/tricks/{id}/edit" , name="trick_edit")
     */
    public function form(Trick $trick=null,Request $request, ObjectManager $manager)
    {
         
        if(!$trick)
        {
            $trick = new Trick();
        
        }
        // $form = $this->createFormBuilder($trick)
        //              ->add('title')
        //              ->add('description')
        //              ->add('image')
        //              ->add('video')
        //              ->getForm();

        $form = $this->createForm(TrickType::class, $trick);

        $form = $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            // if id of trick exist , i don't have recreate the date
            if(!$trick->getId()){
                $trick->setCreatedAt(new \DateTime);
            }
             $manager->persist($trick);
             $manager->flush();

             return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        

        return $this->render('tricks/create.html.twig', [
            'formTrick' => $form->createView(),
            'edit_mode' => $trick->getId() !== null
        ]);
    }

    /**
     * @route("/tricks/{id}", name="trick_show")
     */
    public function show(Trick $trick)
    {
        // this function will retrieve the identifier thanks to the param convert
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick
        ]);
    }


}
