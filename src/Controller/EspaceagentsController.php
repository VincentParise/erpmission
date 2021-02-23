<?php

namespace App\Controller;

use App\Entity\Agents;
use App\Repository\AgentsRepository;
use App\Repository\MissionsRepository;
use App\Repository\PaysRepository;
use App\Repository\SpecialitesRepository;
use App\Repository\StatutsmissionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspaceagentsController extends AbstractController
{
    /**
     * @Route("/espaceagents", name="espaceagents")
     * @param AgentsRepository $agentsRepository
     * @param Request $request
     * @param MissionsRepository $missionsRepository
     * @param PaysRepository $paysRepository
     * @param SpecialitesRepository $specialitesRepository
     * @param StatutsmissionsRepository $statutsmissionsRepository
     * @return Response
     */
    public function index(AgentsRepository $agentsRepository,Request $request,MissionsRepository $missionsRepository,PaysRepository $paysRepository,SpecialitesRepository $specialitesRepository,StatutsmissionsRepository $statutsmissionsRepository): Response
    {
        // On récupère les missions de l'agent : Note injection de MissionsRepository
        // au lieu de :
        // $mission=$this->>getUser()->getMissions()
        $missions=$missionsRepository->findAll();

        // LISTE DEROULANTE : pour le filtrage
        // On récupère dans un tableau les pays des missions de l'agent
        $paysMissions=[];
        foreach($this->getUser()->getMissions() as $element){
                if (!in_array($element->getPaysmission()->getLibelle(),$paysMissions)){
                        $paysMissions[]=$element->getPaysmission()->getLibelle();
                }
           }
        // On récupère dans un tableau les spécialités des missions de l'agent
        $specialiteMissions=[];
        foreach($this->getUser()->getMissions() as $element){
            if (!in_array($element->getSpecialitemission()->getLibelle(),$specialiteMissions)){
                $specialiteMissions[]=$element->getSpecialitemission()->getLibelle();
            }
        }
        // On récupère dans un tableau les Statuts des missions de l'agent
        $statutMissions=[];
        foreach($this->getUser()->getMissions() as $element){
            if (!in_array($element->getStatutmission()->getLibelle(),$statutMissions)){
                $statutMissions[]=$element->getStatutmission()->getLibelle();
            }
        }

        // On vérifie si on a une requete Ajax
        if($request->get('ajax')){
            // On récupère le filtre pays
            $paysFilter=$request->get('pays');
            // On cherche l'Id de la base de donnée
            $idPays=$paysRepository->findIdByLibelle($paysFilter);

            // On récupère le filtre specialité
            $specialiteFilter=$request->get('specialites');
            // On cherche l'Id de la base de donnée
            $idSpecialites=$specialitesRepository->findIdByLibelle($specialiteFilter);

            // On récupère le filtre statut
            $statutFilter=$request->get('statut');
            // On cherche l'Id de la base de donnée
            $idStatut=$statutsmissionsRepository->findIdByLibelle($statutFilter);

            // On recherche avec le repo en fonction des Id dans la base de donnée
            if (empty($idPays) && empty($idSpecialites) && empty($idStatut)){
                $missions=$missionsRepository->findAll();
            }
            if (empty($idPays) && empty($idSpecialites) && !empty($idStatut)){
                $missions=$missionsRepository->findBy([
                    'statutmission' => $idStatut
                ]);
            }
            if (!empty($idPays) && !empty($idSpecialites) && empty($idStatut)) {
                $missions = $missionsRepository->findBy([
                    'paysmission' => $idPays,
                    'specialitemission' => $idSpecialites
                ]);
            }
            if (!empty($idPays) && !empty($idSpecialites) && !empty($idStatut)) {
                $missions = $missionsRepository->findBy([
                    'paysmission' => $idPays,
                    'specialitemission' => $idSpecialites,
                    'statutmission' => $idStatut
                ]);
            }
            if (!empty($idPays) && empty($idSpecialites) && empty($idStatut)) {
                $missions = $missionsRepository->findBy([
                    'paysmission' => $idPays
                ]);
            }
            if (!empty($idPays) && empty($idSpecialites) && !empty($idStatut)) {
                $missions = $missionsRepository->findBy([
                    'paysmission' => $idPays,
                    'statutmission' => $idStatut
                ]);
            }
            if (empty($idPays) && !empty($idSpecialites) && empty($idStatut)) {
                $missions = $missionsRepository->findBy([
                    'specialitemission' => $idSpecialites
                ]);
            }
            if (empty($idPays) && !empty($idSpecialites) && !empty($idStatut)) {
                $missions = $missionsRepository->findBy([
                    'specialitemission' => $idSpecialites,
                    'statutmission' => $idStatut
                ]);
            }

           return new JsonResponse([
                        'content'=>$this->renderView('espaceagents/content_missions.html.twig',['missions'=>$missions])
           ]);
        }

        return $this->render('espaceagents/index.html.twig',[
            'missions'=>$missions,
            'paysmissions'=>$paysMissions,
            'specialitesmissions'=>$specialiteMissions,
            'statutsmissions'=>$statutMissions
        ]);
    }
}
