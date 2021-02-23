<?php

namespace App\Controller;

use App\Entity\Agents;
use App\Repository\AgentsRepository;
use App\Repository\MissionsRepository;
use App\Repository\PaysRepository;
use App\Repository\SpecialitesRepository;
use App\Repository\StatutsmissionsRepository;
use App\Services\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspaceagentsController extends AbstractController
{
    private $missionsRepository;
    private $agentsRepository;

    /**
     * EspaceagentsController constructor.
     * @param MissionsRepository $missionsRepository
     * @param AgentsRepository $agentsRepository
     */
    public function __construct(MissionsRepository $missionsRepository,AgentsRepository $agentsRepository)
    {
        $this->missionsRepository = $missionsRepository;
        $this->agentsRepository=$agentsRepository;
    }

    /**
     * @Route("/espaceagents", name="espaceagents")
     * @param Request $request
     * @param Search $search
     * @param AgentsRepository $agentsRepository
     * @return Response
     */
    public function index(Request $request,Search $search): Response
    {
       // On récupère les missions de l'agent :
       $missions=$this->getUser()->getMissions();
        //dd($this->getUser());

        // LISTE DEROULANTE : pour le filtrage
        // On récupère dans un tableau les pays des missions de l'agent
        $paysMissions=[];
        foreach($missions as $element){
                if (!in_array($element->getPaysmission()->getLibelle(),$paysMissions)){
                        $paysMissions[]=$element->getPaysmission()->getLibelle();
                }
           }
        // On récupère dans un tableau les spécialités des missions de l'agent
        $specialiteMissions=[];
        foreach($missions as $element){
            if (!in_array($element->getSpecialitemission()->getLibelle(),$specialiteMissions)){
                $specialiteMissions[]=$element->getSpecialitemission()->getLibelle();
            }
        }
        // On récupère dans un tableau les Statuts des missions de l'agent
        $statutMissions=[];
        foreach($missions as $element){
            if (!in_array($element->getStatutmission()->getLibelle(),$statutMissions)){
                $statutMissions[]=$element->getStatutmission()->getLibelle();
            }
        }
        //Mise en tableau de l'objet des Missions de l'agent
        $tabMissions=[];
        foreach($missions as $key=>$element){
            $tabMissions[$key]=$element;
        }


        //dd($tabMissions[2]->getStatutmission()->getLibelle());


        // On vérifie si on a une requete Ajax
        if($request->get('ajax')){
            //$missions=$search->filterMissionsAgents($request->get('pays'),$request->get('specialites'),$request->get('statut'),$this->getUser());
            $missions=$search->filterMissionsAgents($request->get('pays'),$request->get('specialites'),$request->get('statut'),$tabMissions);

           return new JsonResponse([
                        'content'=>$this->renderView('espaceagents/content_missions.html.twig',['missions'=>$missions])
           ]);
        }

        return $this->render('espaceagents/index.html.twig',[
            'missions'=>$tabMissions,
            'paysmissions'=>$paysMissions,
            'specialitesmissions'=>$specialiteMissions,
            'statutsmissions'=>$statutMissions
        ]);
    }
}
