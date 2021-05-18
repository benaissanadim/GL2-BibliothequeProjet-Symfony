<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("" , name="home")
     */
    public function home()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/home", name="home")
     */
    public function welcome(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/shopgrid", name="shopgrid")
     */
    public function shopgrid(): Response
    {
        return $this->render('home/shopgrid.html.twig');
    }
}
