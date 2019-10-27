<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
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
