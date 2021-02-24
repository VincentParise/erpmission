<?php

namespace App\Controller;

use App\Entity\Agents;
use App\Form\AgentsType;
use App\Repository\AgentsRepository;
use App\Repository\MissionsRepository;
use App\Services\Rules;
use App\Services\Search;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/agents")
 */
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
     * @Route("/", name="agents_index", methods={"GET"})
     * @param AgentsRepository $agentsRepository
     * @param Search $search
     * @param Request $request
     * @return Response
     */
    public function index(AgentsRepository $agentsRepository,Search $search,Request $request): Response
    {

        $agents=$agentsRepository->findAll();
        // LISTE DEROULANTE : pour le filtrage
        // On récupère dans un tableau les pays de l'agent
        $paysAgents=$search->filterPaysAgents($agents);
        // On récupère dans un tableau les spécialités des missions de l'agent
        $specialiteAgents=$search->filterSpecialitesAgents($agents);


        // On vérifie si on a une requete Ajax
        if($request->get('ajax')){
            // Lancement repo mission pour recherche mot filtrage
            $agents=$agentsRepository->findMotRecherche($request->get('recherche'));

            // Transforme  $agents en tableau pour traitement.
            $tabAgents=[];
            foreach($agents as $key=>$element){
                $tabAgents[$key]=$element;
            }
            $agents=$search->filterAgents($request->get('pays'),$request->get('specialites'),$tabAgents);

            return new JsonResponse([
                'content'=>$this->renderView('agents/content_index.html.twig',['agents' =>$agents])
            ]);
        }

        return $this->render('agents/index.html.twig', [
            'agents' =>$agents,
            'paysagents'=>$paysAgents,
            'specialitesagents'=>$specialiteAgents,
        ]);
    }

    /**
     * @Route("/new", name="agents_new", methods={"GET","POST"})
     * @param Request $request
     * @param Rules $rules
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function new(Request $request,Rules $rules,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $agent = new Agents();
        $form = $this->createForm(AgentsType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Récupération objet tableaux des spécialités de l'agent
            $specialites=$form->get('specialites')->getData();
            //On test si l'agent a au moins une spécialités.
            if (empty($rules->ruleSpecialitesAgents($specialites))){
                $this->addFlash('alert','L\'agent doit avoir au moins une spécialitée');
                return $this->redirectToRoute('agents_new');
            }

            // On encode le mot de passe avant le flush base de données
            $password=$passwordEncoder->encodePassword($agent,$form->get('password')->getData());
            $agent->setPassword($password);
            // Role = 'ROLE_AGENT'
            $agent->setRoles(["ROLE_AGENT"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('agents_index');
        }

        return $this->render('agents/new.html.twig', [
            'agent' => $agent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agents_show", methods={"GET"})
     */
    public function show(Agents $agent): Response
    {
        return $this->render('agents/show.html.twig', [
            'agent' => $agent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agents_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Agents $agent
     * @param Rules $rules
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function edit(Request $request, Agents $agent,Rules $rules,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(AgentsType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Récupération objet tableaux des spécialités de l'agent
            $specialites=$form->get('specialites')->getData();
            //On test si l'agent a au moins une spécialités.
            if (empty($rules->ruleSpecialitesAgents($specialites))){
                $this->addFlash('alert','L\'agent doit avoir au moins une spécialitée');
                return $this->redirectToRoute('agents_edit',['id'=>$agent->getId()]);
            }

            // On encode le mot de passe avant le flush base de données
            $password=$passwordEncoder->encodePassword($agent,$form->get('password')->getData());
            $agent->setPassword($password);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agents_index');
        }

        return $this->render('agents/edit.html.twig', [
            'agent' => $agent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agents_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Agents $agent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agents_index');
    }
}
