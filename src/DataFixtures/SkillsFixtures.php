<?php

namespace App\DataFixtures;

use App\Entity\Skills;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SkillsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();


        for ($i = 0; $i < 50; $i++) {
            $randomUser = $users[array_rand($users)];
            $object = (new Skills())
                ->setName($faker->colorName())
                ->setCreatedBy($randomUser);
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}

