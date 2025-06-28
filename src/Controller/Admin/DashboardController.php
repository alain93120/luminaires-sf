<?php

namespace App\Controller\Admin;

use App\Entity\Settings;
use App\Entity\Commande;
use App\Entity\Paiement;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
{
    // Redirige direct vers la liste des utilisateurs par exemple (ou Commande, Paiement…)
    return $this->redirect($this->generateUrl('admin_user_crud'));
}


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Luminaires');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Paramètres email', 'fa fa-cog', Settings::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-list', Commande::class);
        yield MenuItem::linkToCrud('Paiements', 'fas fa-money-bill', Paiement::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
    }
}
