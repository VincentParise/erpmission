<?php

namespace App\Controller;

use App\Classe\Rules;
use App\Entity\Missions;
use App\Form\MissionsAgentsType;
use App\Form\MissionsCiblesType;
use App\Form\MissionsContactsType;
use App\Form\MissionsPlanquesType;
use App\Form\MissionsType;
use App\Repository\MissionsRepository;
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
        $tabLibellePlanques=[];
        foreach($paysplanques as $key=>$element){
            $tabLibellePlanques[]=$element->getPaysPlanque()->getLibelle();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère le champ pays de la mission
            $paysMission=$form->get('paysmission')->getData()->getLibelle();
            // On test si le pays de la mission fait bien parti des pays de la planque
            if (!empty($tabLibellePlanques)){
                foreach($tabLibellePlanques as $element){
                    if ($element !== $paysMission) {
                        // Message Flash
                        $this->addFlash('alert','Le pays de mission doit être le même que celui du pays de ou des planques en '.$element);
                        return $this->redirectToRoute('missions_edit',['id'=>$mission->getId()]);
                    }
                }
            }

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
     * @Route("/{id}/cibles", name="missions_cibles", methods={"GET","POST"})
     * @param Request $request
     * @param Missions $mission
     * @param Rules $rules
     * @return Response
     */
    public function editCibles(Request $request, Missions $mission,Rules $rules): Response
    {
        $form = $this->createForm(MissionsCiblesType::class, $mission);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             //On récupère les agents de la mission en cours : objet
             $agents=$mission->getAgents();

             //On récupère la nationalité des cibles saisie dans le formulaire
             $cibles=$form->get('cibles')->getData();

            // On vérifie la règle des nationalités.
            if (!$rules->ruleCiblesAgentsNat($cibles,$agents)) {
                $this->addFlash('alert','Le(s) cible(s) ne peuvent pas avoir la même nationalité que le(s) agent(s).');
                return $this->redirectToRoute('missions_cibles',['id'=>$mission->getId()]);
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('missions_index');

        }

        return $this->render('missions/edit_missions_cibles.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/agents", name="missions_agents", methods={"GET","POST"})
     * @param Request $request
     * @param Missions $mission
     * @param Rules $rules
     * @return Response
     */
    public function editAgents(Request $request, Missions $mission,Rules $rules): Response
    {
        $form = $this->createForm(MissionsAgentsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Récupération collection Agents
            $agents=$form->get('agents')->getData();
            //On récupère la spécialité de la mission :
            $specialite=$mission->getSpecialitemission()->getLibelle();
            //On récupère les cibles des missions :
            $cibles=$mission->getCibles();

           // On vérifie la règle des agents et leur spécialité
            if (!$rules->ruleAgentsSpecialites($specialite,$agents)) {
                $this->addFlash('alert','Au moins 1 agent doit avoir la spécialité de la mission.');
                return $this->redirectToRoute('missions_agents',['id'=>$mission->getId()]);
            }

            // On vérifie la règle des nationalités.
            if (!$rules->ruleCiblesAgentsNat($cibles,$agents)) {
                $this->addFlash('alert','Le(s) agent(s) ne peuvent pas avoir la même nationalité que le(s) cible(s).');
                return $this->redirectToRoute('missions_cibles',['id'=>$mission->getId()]);
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('missions_index');
        }

        return $this->render('missions/edit_missions_agents.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/contacts", name="missions_contacts", methods={"GET","POST"})
     * @param Request $request
     * @param Missions $mission
     * @return Response
     */
    public function editContacts(Request $request, Missions $mission): Response
    {
        $form = $this->createForm(MissionsContactsType::class, $mission);
        $form->handleRequest($request);

        // On récupère le pays de la mission :
        $countryMission=$mission->getPaysmission()->getLibelle();


        if ($form->isSubmitted() && $form->isValid()) {

            // On teste si le pays du contact est le même que la mission
            $contacts=$form->get('contacts')->getData();

            //On test si l'ensemble des contacts est du même pays que la mission
            if (!empty($contacts)){
                foreach($contacts as $key=>$element){
                    if($countryMission !== $contacts[$key]->getPays()->getLibelle()){
                        $this->addFlash('alert','Les contacts doivent être de la même nationalité que la mission');
                        return $this->redirectToRoute('missions_contacts',['id'=>$mission->getId()]);
                    }
                }
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('missions_index');
        }

        return $this->render('missions/edit_missions_contacts.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/missions_delete", name="missions_delete", methods={"DELETE"})
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

    ///*
    ///**
    // * @Route("/{id}/planques/delete", name="planques_delete", methods={"DELETE"})
    // */
    //public function deletePlanques(Request $request, Missions $mission,Planques $planques): Response
    //{
    //    if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->request->get('_token'))) {
//
    //        dd($request->request->get('_planques'));
    //        $mission->removePlanque();
//
    //    }
//
    //    return $this->redirectToRoute('missions_index');
    //}
    //*/
}
