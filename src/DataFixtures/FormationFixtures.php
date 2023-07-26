<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;


class FormationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();


        for ($i = 0; $i < 40; $i++) {
            $randomUser = $users[array_rand($users)];

            $object = (new Formation())
                ->setTitle($faker->word())
                ->setDescription($faker->word())
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