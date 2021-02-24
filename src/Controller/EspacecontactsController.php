<?php

namespace App\Controller;

use App\Services\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspacecontactsController extends AbstractController
{
    /**
     * @Route("/espacecontacts", name="espacecontacts")
     * @param Search $search
     * @param Request $request
     * @return Response
     */
    public function index(Search $search,Request $request): Response
    {
        // On récupère les missions du contact :
        $missions=$this->getUser()->getMissions();
        // On récupère dans un tableau les pays des missions de l'agent
        $paysMissions=$search->filterPaysMissions($missions);

        // On récupère dans un tableau les Statuts des missions de l'agent
        $statutMissions=$search->filterStatutsMissions($missions);

        //Mise en tableau de l'objet des Missions de l'agent
        $tabMissions=[];
        foreach($missions as $key=>$element){
            $tabMissions[$key]=$element;
        }

        // On vérifie si on a une requete Ajax
        if($request->get('ajax')){
            $missions=$search->filterMissionsContacts($request->get('pays'),$request->get('statut'),$tabMissions);

            return new JsonResponse([
                'content'=>$this->renderView('espacecontacts/content_missions.html.twig',['missions'=>$missions])
            ]);
        }




        return $this->render('espacecontacts/index.html.twig',[
            'missions'=>$missions,
            'paysmissions'=>$paysMissions,
            'statutsmissions'=>$statutMissions
        ]);


    }
}
