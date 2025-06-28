<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $produit = new Produit();
            $produit->setNom("Produit $i");
            $produit->setDescription("Description du produit $i");
            $produit->setPrixUnitaire(mt_rand(10, 100));
            $produit->setStock(mt_rand(1, 50)); // <--- Ajoute cette ligne

            $manager->persist($produit);
        }

        $manager->flush();
    }
}
