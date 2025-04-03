<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Evenement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EvenementFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $nbEvenement = $faker->numberBetween(5, 10);
        for($i = 0; $i < $nbEvenement; $i++){

            $evenement = new Evenement();
            $evenement->setTitle($faker->sentence(4, true))
                ->setDate($faker->dateTimeBetween('-1 year'));

                
            
            $manager->persist($evenement);
        }
        $manager->flush();
    }
}
