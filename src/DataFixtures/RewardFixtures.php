<?php

namespace App\DataFixtures;

use App\Entity\Reward;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RewardFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();

        for ($i = 0; $i < 10; $i++) {
            $randomUser = $users[array_rand($users)];
            $object = (new Reward())
                ->setName($faker->name())
                ->setDescription($faker->sentence(20))
                ->setPoints(random_int(20, 100))
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