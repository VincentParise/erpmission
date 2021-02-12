<?php

namespace App\Controller;

use App\Entity\Cibles;
use App\Entity\Missions;
use App\Entity\Planques;
use App\Form\MissionsPlanquesType;
use App\Form\MissionsType;
use App\Repository\MissionsRepository;
use App\Repository\PaysRepository;
use App\Repository\PlanquesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/missions")
 */
class MissionsController extends AbstractController
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
     * @Route("/", name="missions_index", methods={"GET"})
     */
    public function index(MissionsRepository $missionsRepository): Response
    {
        return $this->render('missions/index.html.twig', [
            'missions' => $missionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="missions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mission = new Missions();
        $form = $this->createForm(MissionsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mission);
            $entityManager->flush();

            return $this->redirectToRoute('missions_index');
        }

        return $this->render('missions/new.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="missions_show", methods={"GET"})
     */
    public function show(Missions $mission): Response
    {
        return $this->render('missions/show.html.twig', [
            'mission' => $mission,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="missions_edit", methods={"GET","POST"})
     * @param Missions $mission
     */
    public function edit(Request $request, Missions $mission): Response
    {

        $form = $this->createForm(MissionsType::class, $mission);
        $form->handleRequest($request);

        //Recupération des libelle pays des planques de la mission.
        $paysplanques=$mission->getPlanques();
        $tab=[];
        foreach($paysplanques as $key=>$element){
            $tab[]=$element->getPaysPlanque()->getLibelle();
        }
        dd($tab);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('missions_index');
        }

        return $this->render('missions/edit.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/planques", name="missions_planques", methods={"GET","POST"})
     * @param Request $request
     * @param Missions $mission
     * @return Response
     */
    public function editPlanques(Request $request, Missions $mission): Response
    {
        $form = $this->createForm(MissionsPlanquesType::class, $mission);
        $form->handleRequest($request);

        //Recupération de l'id et du libellé du pays de la mission.
        $paysmission=$mission->getPaysmission();
        $paysmission->getLibelle();

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère l'objet planque
            $planques=$form->get('planques')->getData();
            // On recherche parmis ces éléments si le pays de la mission = pays de la planque
            foreach($planques as $key=>$element){
                if ($planques[$key]->getPaysplanque()->getLibelle() !== $paysmission->getLibelle()){
                    // Message Flash
                    $this->addFlash('alert','Le pays de la planque doit être le même que celui du pays de la mission');
                    return $this->redirectToRoute('missions_planques',['id'=>$mission->getId()]);
                }
            }

            //$pays=$planquesRepository->findAllPaysByIdPlanque('Allemagne');
            //$mkt=$request->request->get('missions_planques');

            $this->entityManager->flush();
            //$this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('missions_index');
        }

        return $this->render('missions/edit_missions_planques.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="missions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Missions $mission): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('missions_index');
    }
}
