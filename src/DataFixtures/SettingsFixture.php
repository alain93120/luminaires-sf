<?php

namespace App\DataFixtures;

use App\Entity\Settings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SettingsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $settings = new Settings();
        $settings->setMailerEmail('tonmail@tondomaine.fr');
        $settings->setMailerName('Donkey Luminaires');

        $manager->persist($settings);
        $manager->flush();
    }
}
