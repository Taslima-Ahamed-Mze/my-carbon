<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;


class EventFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();


        for ($i=0; $i < 40; $i++) { 
            $randomUser = $users[array_rand($users)];

            $object = (new Event())
           
            ->setTitle($faker->word()) 
            ->setDescription($faker->word()) 
            ->setStartDate($faker->dateTime())
            ->setEndDate($faker->dateTime())  
            ->setCreatedBy($randomUser)
        ;

        $manager->persist($object);
        $manager->flush();
    }
  
        }
    
}