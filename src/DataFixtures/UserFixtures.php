<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@demo.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->hasher->hashPassword($user, 'admin123');
        $user->setPassword($hashedPassword);
        $user->setIsVerified(true); // Si tu as ce champ

        $manager->persist($user);
        $manager->flush();
    }
}
