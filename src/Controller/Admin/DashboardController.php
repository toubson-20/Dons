<?php

namespace App\Controller\Admin;

use App\Entity\Campagne;
use App\Entity\Departement;
use App\Entity\Donneur;
use App\Entity\Dons;
use App\Entity\Hopital;
use App\Entity\Points;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(HopitalCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dons Pour Tous');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linktoRoute('Accueil', 'fas fa-home', 'app_hopital');
        yield MenuItem::linkToCrud('Hôpital', 'fas fa-hospital', Hopital::class);
        yield MenuItem::linkToCrud('Département', 'fas fa-map-marker-alt', Departement::class);
        yield MenuItem::linkToCrud('Campagne', 'fas fa-leaf', Campagne::class);
        yield MenuItem::linkToCrud('Donneur', 'fas fa-heart', Donneur::class);
        yield MenuItem::linkToCrud('Dons', 'fas fa-tint', Dons::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', Utilisateur::class);
        yield MenuItem::linkToCrud('Points', 'fas fa-coins', Points::class);
    }
}
