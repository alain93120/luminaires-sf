<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_view')]
    public function view(CartRepository $carts): Response
    {
        $user = $this->getUser();
        $cart = $carts->findOneByUser($user)
            ?? $carts->createForUser($user);

        return $this->render('cart/view.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(
        int $id,
        ProduitRepository $prods,
        CartRepository $carts,
        CartItemRepository $items,
        EntityManagerInterface $em
    ): Response {
        $prod = $prods->find($id);
        $user = $this->getUser();
        $cart = $carts->findOneByUser($user) ?? $carts->createForUser($user);

        // on cherche s’il existe déjà une ligne pour ce produit
        $item = $items->findOneByCartAndProduit($cart, $prod)
            ?: (new CartItem())->setProduit($prod);

        $item->setQuantity($item->getQuantity() + 1);
        $cart->addItem($item);

        $em->persist($cart);
        $em->flush();

        return $this->redirectToRoute('cart_view');
    }

    #[Route('/cart/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function update(
        CartItem $item,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $q = max(1, (int) $request->request->get('quantity', $item->getQuantity()));
        $item->setQuantity($q);
        $em->flush();

        return $this->redirectToRoute('cart_view');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(
        CartItem $item,
        EntityManagerInterface $em
    ): Response {
        $em->remove($item);
        $em->flush();

        return $this->redirectToRoute('cart_view');
    }

    #[Route('/cart/checkout', name: 'cart_checkout')]
    public function checkout(
        CartRepository $carts,
        CartItemRepository $items,
        EntityManagerInterface $em
    ): Response {
        $user = $this->getUser();
        if ($cart = $carts->findOneByUser($user)) {
            // si vous avez une entité Order, vous pouvez la créer ici...
            $items->removeAllFromCart($cart);
            $em->flush();
        }

        return $this->redirectToRoute('cart_view');
    }
}
