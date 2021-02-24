<?php

namespace App\Controller;


use App\Repository\AgentsRepository;
use App\Repository\MissionsRepository;
use App\Services\Search;
use Knp\Component\Pager\PaginatorInterface;
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
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request,Search $search,PaginatorInterface $paginator): Response
    {
       // On récupère les missions de l'agent :
       $missions=$this->getUser()->getMissions();

        // LISTE DEROULANTE : pour le filtrage
        // On récupère dans un tableau les pays des missions de l'agent
        $paysMissions=$search->filterPaysMissions($missions);

        // On récupère dans un tableau les spécialités des missions de l'agent
        $specialiteMissions=$search->filterSpecialitesMissions($missions);

        // On récupère dans un tableau les Statuts des missions de l'agent
        $statutMissions=$search->filterStatutsMissions($missions);

        //Mise en tableau de l'objet des Missions de l'agent
        $tabMissions=[];
        foreach($missions as $key=>$element){
            $tabMissions[$key]=$element;
        }

        // On vérifie si on a une requete Ajax
        if($request->get('ajax')){
            //$missions=$search->filterMissionsAgents($request->get('pays'),$request->get('specialites'),$request->get('statut'),$this->getUser());
            $missions=$search->filterMissionsAgents($request->get('pays'),$request->get('specialites'),$request->get('statut'),$tabMissions);

            return new JsonResponse([
                        'content'=>$this->renderView('espaceagents/content_missions.html.twig',['missions'=>$missions])
           ]);
        }

        // Pagination par le bundle knpPaginator
        //$tabMissions = $paginator->paginate(
        //    $tabMissions, // Requête contenant les données à paginer (ici nos articles)
        //    $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
        //    2 // Nombre de résultats par page
        //);

        return $this->render('espaceagents/index.html.twig',[
            'missions'=>$tabMissions,
            'paysmissions'=>$paysMissions,
            'specialitesmissions'=>$specialiteMissions,
            'statutsmissions'=>$statutMissions
        ]);
    }
}
