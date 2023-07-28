<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Cooptation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CooptationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();




        for ($i = 0; $i < 50; $i++) {
            $randomUser = $users[array_rand($users)];
            $object = (new Cooptation())
                ->setEmail($faker->email())
                ->setLastname($faker->lastName())
                ->setFirstname($faker->firstName())
                ->setCvName($faker->filePath())
                ->setStatus('En cours')
                ->setCreatedBy($randomUser);
            $manager->persist($object);
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

}