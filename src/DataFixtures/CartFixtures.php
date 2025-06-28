<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CartFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // On suppose que tu as déjà 5 users créés et référencés via UserFixtures
        for ($i = 1; $i <= 5; $i++) {
            $cart = new Cart();

            /** @var User $user */
            $user = $this->getReference('user_' . $i);

            $cart->setUser($user);

            $manager->persist($cart);

            // Pour réutiliser ce cart dans d'autres fixtures
            $this->addReference('cart_' . $i, $cart);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
