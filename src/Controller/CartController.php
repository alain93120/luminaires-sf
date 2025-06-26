<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/cart', name: 'cart_view')]
    public function view(CartRepository $carts): Response
    {
        $user = $this->getUser();
        $cart = $carts->findOneByUser($user) ?? $carts->createForUser($user);

        return $this->render('cart/view.html.twig', ['cart' => $cart]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(
        int $id,
        ProduitRepository $prods,
        CartRepository $carts,
        CartItemRepository $items,
        EntityManagerInterface $em
    ): Response {
        // … votre logique …
        return new Response('Produit ajouté au panier !');

    }

    // Répétez pour update, remove, checkout…
}
