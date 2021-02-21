<?php

namespace App\Controller;

use App\Repository\MissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AgentsController extends AbstractController
{
    private $entityManager;

    /**
     * MissionsController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/agents", name="agents")
     * @param MissionsRepository $missionsRepository
     * @return Response
     */
    public function index(MissionsRepository $missionsRepository): Response
    {
        //dd($this->getUser()->getMissions());

        return $this->render('missions/index.html.twig', [
            'missions' => $this->getUser()->getMissions(),
        ]);
    }

}
