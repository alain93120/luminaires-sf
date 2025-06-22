<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartItem>
 *
 * @method CartItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartItem[]    findAll()
 * @method CartItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    /**
     * Retourne l’élément du panier pour un produit donné, ou null.
     */
    public function findOneByCartAndProduit(Cart $cart, Produit $produit): ?CartItem
    {
        return $this->findOneBy([
            'cart'    => $cart,
            'produit' => $produit,
        ]);
    }

    /**
     * Supprime tous les items d’un panier (pour le checkout).
     */
    public function removeAllFromCart(Cart $cart): void
    {
        $qb = $this->createQueryBuilder('i')
            ->delete()
            ->where('i.cart = :cart')
            ->setParameter('cart', $cart);

        $qb->getQuery()->execute();
    }
}
