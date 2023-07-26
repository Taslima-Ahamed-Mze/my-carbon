<?php

namespace App\DataFixtures;


use App\Entity\Formation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FormationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');



        for ($i = 0; $i < 50; $i++) {

            $object = (new Formation())
                ->setTitle($faker->title())
                ->setDescription($faker->sentence());
            $manager->persist($object);
        }
        $manager->flush();
    }
}
