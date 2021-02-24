<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\MissionsAgentsType;
use App\Form\MissionsCiblesType;
use App\Form\MissionsContactsType;
use App\Form\MissionsPlanquesType;
use App\Form\MissionsType;
use App\Repository\MissionsRepository;
use App\Services\Rules;
use App\Services\Search;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param MissionsRepository $missionsRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param Search $search
     * @return Response
     */
    public function index(MissionsRepository $missionsRepository,PaginatorInterface $paginator,Request $request,Search $search): Response
    {
        //On définit le nombre de missions par page :
        //$limit=3;
        //// On récupère le numéro de page
        //$page = (int)$request->query->get("page", 1);
        //// On récupère les missions de la page en fonction du filtre
        //$missions = $missionsRepository->getPaginatedMissions($page, $limit);
        //// On récupère le nombre total de missions
        //$total = $missionsRepository->getTotalMissions();
        // Pagination par le bundle knpPaginator
        //$missions = $paginator->paginate(
        //    $missions, // Requête contenant les données à paginer
        //    $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
        //    3 // Nombre de résultats par page
        //);

        $missions=$missionsRepository->findAll();

        // LISTE DEROULANTE : pour le filtrage
        // On récupère dans un tableau les pays des missions de l'agent
        $paysMissions=$search->filterPaysMissions($missions);

        // On récupère dans un tableau les spécialités des missions de l'agent
        $specialiteMissions=$search->filterSpecialitesMissions($missions);

        // On récupère dans un tableau les Statuts des missions de l'agent
        $statutMissions=$search->filterStatutsMissions($missions);

        // On vérifie si on a une requete Ajax
        if($request->get('ajax')){
            // Lancement repo mission pour recherche mot filtrage
            $missions=$missionsRepository->findMotRecherche($request->get('recherche'));

            // Transforme $missions en tableau pour traitement.
            $tabMissions=[];
            foreach($missions as $key=>$element){
                $tabMissions[$key]=$element;
            }

            $missions=$search->filterMissionsAgents($request->get('pays'),$request->get('specialites'),$request->get('statut'),$tabMissions);

            return new JsonResponse([
                'content'=>$this->renderView('missions/content_index.html.twig',['missions'=>$missions])
            ]);
        }

       return $this->render('missions/index.html.twig', [
            'missions' =>  $missions,
            'paysmissions'=>$paysMissions,
            'specialitesmissions'=>$specialiteMissions,
            'statutsmissions'=>$statutMissions

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
     * @param Request $request
     * @param Missions $mission
     * @param Rules $rules
     * @return Response
     */
    public function edit(Request $request, Missions $mission,Rules $rules): Response
    {

        $form = $this->createForm(MissionsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Vérification pour passer changer l'état de la mission :
            // Récupération Id, Statut, Pays, Planques Mission en cours  :
            $etatMission=$mission->getStatutmission()->getId();
            $statutMission=$mission->getStatutmission()->getLibelle();
            $countryMission=$mission->getPaysmission()->getLibelle();
            $planques=$mission->getPlanques();
            // Si Etat Mission <> de préparation :
            if ($etatMission!=1){

                // -1 Présence Agent Cible et Contact
                $agents=$mission->getAgents();
                $contacts=$mission->getContacts();
                $cibles=$mission->getCibles();
                if (!$rules->verifAgentsContactsCibles($agents,$contacts,$cibles,$statutMission)) {
                    return $this->redirectToRoute('missions_edit',['id'=>$mission->getId()]);
                }
                // -2 Vérification que Cibles et Agents ont la même nationailité:
                if (!$rules->ruleCiblesAgentsNat($cibles,$agents)) {
                    $this->addFlash('alert','Le(s) cible(s) ne peuvent pas avoir la même nationalité que le(s) agent(s).');
                    return $this->redirectToRoute('missions_edit',['id'=>$mission->getId()]);
                }
                // -3 Vérification si le pays mission = pays du contact
                if (!$rules->ruleContactsPays($countryMission,$contacts)){
                    $this->addFlash('alert','Les contacts doivent être du même pays que la mission : '.$mission->getPaysmission()->getLibelle());
                    return $this->redirectToRoute('missions_edit',['id'=>$mission->getId()]);
                }
                // -4 Vérification Planque même pays que mission
                if (!$rules->rulePlanquesPays($countryMission,$planques)){
                    return $this->redirectToRoute('missions_edit',['id'=>$mission->getId()]);
                }
                // -5 Vérification si la specialite de la mission correspond au moins à une specialité d'un agent
                //On recupere le champ specialite de la mission :
                $specialitemission= $form->get('specialitemission')->getData()->getLibelle();
                if (!$rules->ruleSpecialiteMissionAgents($specialitemission,$agents)){
                    $this->addFlash('alert','La Spécialité de la mission : '.$specialitemission.' n\'est pas compatible avec au moins une spécialité d\'un agent');
                    return $this->redirectToRoute('missions_edit',['id'=>$mission->getId()]);
                }
                return $this->redirectToRoute('missions_index');

            } else {
                // On récupère le champ pays de la mission
                $paysMission=$form->get('paysmission')->getData()->getLibelle();
                //On test si le pays de la mission fait bien parti des pays de(s) planques
                if (!$rules->rulePlanquesPays($paysMission,$planques)){
                    return $this->redirectToRoute('missions_edit',['id'=>$mission->getId()]);
                }

                //On recupere le champ specialite de la mission :
                $specialitemission= $form->get('specialitemission')->getData()->getLibelle();
                //Recupération des libelles specialité des agents.
                $agents=$mission->getAgents();
                //On test si la specialite de la mission fait bien parti au moins des specialités de(s) agent(s)
                if (!$rules->ruleSpecialiteMissionAgents($specialitemission,$agents)){
                    $this->addFlash('alert','La Spécialité de la mission : '.$specialitemission.' n\'est pas compatible avec au moins une spécialité d\'un agent');
                    return $this->redirectToRoute('missions_edit',['id'=>$mission->getId()]);
                }
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('missions_index');
            }
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
     * @param Rules $rules
     * @return Response
     */
    public function editPlanques(Request $request, Missions $mission,Rules $rules): Response
    {
        $form = $this->createForm(MissionsPlanquesType::class, $mission);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            //Recupération de l'id et du libellé du pays de la mission.
            $paysmission=$mission->getPaysmission()->getLibelle();
            // On récupère l'objet planque
            $planques=$form->get('planques')->getData();
            // On appelle la règle et on test.
            if (!$rules->rulePaysPlanque($paysmission,$planques)){
                $this->addFlash('alert', 'Le pays de la planque doit être le même que celui du pays de la mission : '.$mission->getPaysmission()->getLibelle());
                return $this->redirectToRoute('missions_planques', ['id' => $mission->getId()]);
            }

            $this->entityManager->flush();

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

            // On vérifie la règle des nationalités en appelant le service Rules.
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
     * @Route("/{id}/agents", name="agents_missions", methods={"GET","POST"})
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
            // On appelle le service Rules
            if (!$rules->ruleAgentsSpecialites($specialite,$agents)) {
                $this->addFlash('alert','Au moins 1 agent doit avoir la spécialité de la mission : '.$mission->getSpecialitemission()->getLibelle());
                return $this->redirectToRoute('agents_missions',['id'=>$mission->getId()]);
            }

            // On vérifie la règle des nationalités.
            if (!$rules->ruleCiblesAgentsNat($cibles,$agents)) {
                // On récupère les nationalités des cibles dans une chaine de caractère.
                $nationaliteCibles=$rules->ruleNatCibles($cibles);
                $this->addFlash('alert','Le(s) agent(s) ne peuvent pas avoir la même nationalité que le(s) cible(s) : '.$nationaliteCibles);
                return $this->redirectToRoute('agents_missions',['id'=>$mission->getId()]);
            }

            $this->getDoctrine()->getManager()->flush();
            //dd($this->getDoctrine()->getManager()->flush());

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
     * @param Rules $rules
     * @return Response
     */
    public function editContacts(Request $request, Missions $mission,Rules $rules): Response
    {
        $form = $this->createForm(MissionsContactsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère le pays de la mission :
            $countryMission=$mission->getPaysmission()->getLibelle();
            // On teste si le pays du contact est le même que la mission
            $contacts=$form->get('contacts')->getData();

            //Service Rules et on test si contacts même nat que la mission  //$rules=$this->container->get('rules');
            if (!$rules->ruleContactsPays($countryMission,$contacts)){
                $this->addFlash('alert','Les contacts doivent être du même pays que la mission : '.$mission->getPaysmission()->getLibelle());
                return $this->redirectToRoute('missions_contacts',['id'=>$mission->getId()]);
            }

            $this->getDoctrine()->getManager()->flush();

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

}
