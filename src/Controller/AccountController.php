<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountFormType;
use App\Repository\CommandeRepository;
use App\Repository\PaiementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AccountController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/account', name: 'app_account')]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        CommandeRepository $commandeRepo,
        PaiementRepository $paiementRepo
    ): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(AccountFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Profil mis à jour !');
        }

        // Récupérer les commandes et paiements de l'utilisateur
        $commandes = $commandeRepo->findBy(['user' => $user]);
        $paiements = $paiementRepo->findBy(['user' => $user]);

        return $this->render('account/index.html.twig', [
            'accountForm' => $form,
            'commandes'   => $commandes,
            'paiements'   => $paiements,
        ]);
    }
}
