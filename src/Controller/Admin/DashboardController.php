<?php

namespace App\Controller\Admin;

use App\Entity\Agents;
use App\Entity\Cibles;
use App\Entity\Contacts;
use App\Entity\Pays;
use App\Entity\Planques;
use App\Entity\Specialites;
use App\Entity\Statutsmissions;
use App\Entity\Typesmissions;
use App\Entity\Typesplanques;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {

        //return parent::index();
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(ContactsCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DASHBOARD ERP-MISSION')

            ;

    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Utilisateurs Connect');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);

        yield MenuItem::section('Contacts');
        yield MenuItem::linkToCrud('Contacts', 'fas fa-users', Contacts::class);

        yield MenuItem::section('Agents');
        yield MenuItem::linkToCrud('Agents', 'fas fa-users', Agents::class);

        yield MenuItem::section('Paramétrages Divers');
        yield MenuItem::linkToCrud('Pays', 'fas fa-globe', Pays::class);
        yield MenuItem::linkToCrud('Statut Missions', 'fas fa-thermometer-quarter', Statutsmissions::class);
        yield MenuItem::linkToCrud('Type Missions', 'fas fa-font', Typesmissions::class);
        yield MenuItem::linkToCrud('Type Planque', 'fas fa-font', Typesplanques::class);
        yield MenuItem::linkToCrud('Spécialité', 'fas fa-font', Specialites::class);

        yield MenuItem::section('Les planques');
        yield MenuItem::linkToCrud('Planques', 'fas fa-eye-slash', Planques::class);

        yield MenuItem::section('Les Cibles');
        yield MenuItem::linkToCrud('Cibles', 'fas fa-bullseye', Cibles::class);

        yield MenuItem::section('Gestion Des Missions');
        yield MenuItem::linktoRoute('Gestion Missions', 'fas fa-briefcase', 'missions_index');

        yield MenuItem::section('Retour');
        yield MenuItem::linktoRoute('Retour', 'fas fa-home', 'missions_index');


    }
}
