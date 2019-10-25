<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function home()
    {
        return $this->render('tricks/home.html.twig');
    }

    /**
     * @route("/tricks/12", name="trick_show")
     */
    public function show()
    {
        return $this->render('tricks/home.html.twig');
    }
}
