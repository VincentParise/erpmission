<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactsType;
use App\Repository\ContactsRepository;
use App\Services\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/contacts")
 */
class ContactsController extends AbstractController
{
    /**
     * @Route("/", name="contacts_index", methods={"GET"})
     * @param ContactsRepository $contactsRepository
     * @param Request $request
     * @param Search $search
     * @return Response
     */
    public function index(ContactsRepository $contactsRepository,Request $request,Search $search): Response
    {
        $contacts=$contactsRepository->findAll();
        // LISTE DEROULANTE : pour le filtrage
        // On récupère dans un tableau les pays du contact
        $paysContacts=$search->filterPaysContacts($contacts);

        // On vérifie si on a une requete Ajax
        if($request->get('ajax')){
            // Lancement repo mission pour recherche mot filtrage
            $contacts=$contactsRepository->findMotRecherche($request->get('recherche'));

            // Transforme  $agents en tableau pour traitement.
            $tabContacts=[];
            foreach($contacts as $key=>$element){
                $tabContacts[$key]=$element;
            }
            $contacts=$search->filterContacts($request->get('pays'),$tabContacts);

            return new JsonResponse([
                'content'=>$this->renderView('contacts/content_index.html.twig',['contacts' =>$contacts])
            ]);
        }

        return $this->render('contacts/index.html.twig', [
            'contacts' => $contacts,
            'payscontacts'=>$paysContacts
        ]);
    }

    /**
     * @Route("/new", name="contacts_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $contact = new Contacts();
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On encode le mot de passe avant le flush base de données
            $password=$passwordEncoder->encodePassword($contact,$form->get('password')->getData());
            $contact->setPassword($password);
            // Role = 'ROLE_CONTACT'
            $contact->setRoles(["ROLE_CONTACT"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contacts_index');
        }

        return $this->render('contacts/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contacts_show", methods={"GET"})
     */
    public function show(Contacts $contact): Response
    {
        return $this->render('contacts/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contacts_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Contacts $contact
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function edit(Request $request, Contacts $contact, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On encode le mot de passe avant le flush base de données
            $password=$passwordEncoder->encodePassword($contact,$form->get('password')->getData());
            $contact->setPassword($password);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contacts_index');
        }

        return $this->render('contacts/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contacts_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contacts $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contacts_index');
    }
}
