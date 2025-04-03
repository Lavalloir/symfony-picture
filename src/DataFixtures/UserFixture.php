<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ){
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $nbUsers = 10;
        for($i = 0; $i < $nbUsers; $i++){
            $plainPassword ="azerty";
            $user = new User();
            $user->setEmail($faker->email())
                ->setFirstName($faker->firstname())
                ->setName($faker->name())
                ->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));            
            $manager->persist($user);
        }
        $manager->flush();
    }
}
