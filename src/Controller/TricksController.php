<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;
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
     * @route("/tricks/new" , name="trick_new")
     */
    public function create(Request $request, ObjectManager $manager)
    {
         
        $trick = new Trick();

        $form = $this->createFormBuilder($trick)
                     ->add('title')
                     ->add('description')
                     ->add('image')
                     ->add('video')
                     ->getForm();

        $form = $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
             $trick->setCreatedAt(new \DateTime);
             $manager->persist($trick);
             $manager->flush();

             return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        

        return $this->render('tricks/create.html.twig', [
            'formTrick' => $form->createView()
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
