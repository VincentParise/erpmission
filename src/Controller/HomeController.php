<?php

namespace App\Controller;

use App\Repository\MissionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/agentsmissions", name="agentsmissions")
     * @param MissionsRepository $missionsRepository
     * @return Response
     */
    public function agentsMissions(MissionsRepository $missionsRepository): Response
    {

        return $this->render('missions/index.html.twig', [
            'missions' => $this->getUser()->getMissions(),
        ]);
    }
}
