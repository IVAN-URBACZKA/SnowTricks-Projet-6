<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;


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
    public function show(Trick $trick,Request $request, ObjectManager $manager)
    {
         $comment = new Comment();
         $form = $this->createForm(CommentType::class, $comment);
         $form = $form->handleRequest($request);
         if($form->isSubmitted() &&  $form->isValid())
         {
            $comment->setCreatedAt(new \DateTime);
            $comment->setTrick($trick);
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

         }

        // this function will retrieve the identifier thanks to the param convert
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick,
            'formComment' => $form->createView()
            
        ]);
    }


}
