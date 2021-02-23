<?php

namespace App\Controller;

use App\Entity\Agents;
use App\Form\AgentsType;
use App\Repository\AgentsRepository;
use App\Repository\MissionsRepository;
use App\Services\Rules;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @return Response
     */
    public function index(AgentsRepository $agentsRepository): Response
    {
        return $this->render('agents/index.html.twig', [
            'agents' =>$agentsRepository->findAll(),
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
