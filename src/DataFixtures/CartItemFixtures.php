<?php

namespace App\DataFixtures;

use App\Entity\CartItem;
use App\Entity\Produit;
use App\Entity\Cart;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CartItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // On suppose que tu as déjà 5 produits et 5 carts créés avec les références
        for ($i = 1; $i <= 5; $i++) {
            $cartItem = new CartItem();

            /** @var Produit $produit */
            $produit = $this->getReference('produit_' . $i);
            /** @var Cart $cart */
            $cart = $this->getReference('cart_' . $i);

            $cartItem->setProduit($produit);
            $cartItem->setCart($cart);
            $cartItem->setQuantity(mt_rand(1, 5)); // Quantité aléatoire

            $manager->persist($cartItem);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProduitFixtures::class,
            CartFixtures::class,
        ];
    }
}
