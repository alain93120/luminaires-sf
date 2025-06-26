<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'catalogue_tout')]
    public function index(): Response
    {
        // Exemple de 20 produits mockés
        $categories = ['Salon', 'Extérieur', 'Chambre', 'Bureau'];
        $produits = [];
        for ($i = 1; $i <= 20; $i++) {
            $cat = $categories[array_rand($categories)];
            $produits[] = [
                'id' => $i,
                'nom' => "Produit $i",
                'description' => "Superbe $cat numéro $i",
                'prix' => rand(20, 200),
                'categorie' => $cat,
                'image' => "https://picsum.photos/400/300?random=" . $i,
            ];
        }        
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produits,
            'categories' => $categories,
        ]);
    }
}
