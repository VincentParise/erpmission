<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutusController extends AbstractController
{
    /**
     * @Route("/about-us", name="aboutus")
     */
    public function index(): Response
    {
        return $this->render('aboutus/index.html.twig');
    }
}
