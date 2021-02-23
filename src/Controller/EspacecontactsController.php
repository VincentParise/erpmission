<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspacecontactsController extends AbstractController
{
    /**
     * @Route("/espacecontacts", name="espacecontacts")
     */
    public function index(): Response
    {
        return $this->render('espacecontacts/index.html.twig', [
            'controller_name' => 'EspacecontactsController',
        ]);
    }
}
