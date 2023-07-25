<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Offers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;



class OffersFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
       
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();

        for ($i=0; $i < 50; $i++) { 
            $randomUser = $users[array_rand($users)];
            $object = (new Offers())
            ->setName($faker->name())
            ->setAddress($faker->address())
            ->setCompanyName($faker->name())
            ->setCreatedBy($randomUser)
           

            
           
        ;

        $manager->persist($object);
        $manager->flush();
    }
 
        }
        public function getDependencies()
        {
            return [
                ContractFixtures::class,
              
            ];
        }
       
}