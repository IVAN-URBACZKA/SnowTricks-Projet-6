<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;




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
             $this->addFlash(
                'notice',
                'Your Trick is added to the database'
            );

             return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        

        return $this->render('tricks/create.html.twig', [
            'formTrick' => $form->createView(),
            'edit_mode' => $trick->getId() !== null
        ]);
    }


    /**
     * @Route("/tricks/{id}/delete" , name="trick_delete")
     */
    public function deleteTrick(Trick $trick,Request $request, ObjectManager $manager, TrickRepository $repo)
    {
        $manager->remove($trick);
        $manager->flush();
        return $this->redirectToRoute('home');
        
    }

    /**
     * @route("/tricks/{id}", name="trick_show")
     */
    public function show(Trick $trick,Request $request, ObjectManager $manager,UserInterface $user = null)
    {
         $comment = new Comment();
         $form = $this->createForm(CommentType::class, $comment);
         $form = $form->handleRequest($request);
         if($form->isSubmitted() &&  $form->isValid())
         {
            $comment->setCreatedAt(new \DateTime);
            $comment->setUserId($user);
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
