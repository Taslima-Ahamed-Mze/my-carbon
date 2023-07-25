<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProfileFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $object = (new Profile())
            ->setName('Collaborateur')
        ;
        $manager->persist($object);

        $object = (new Profile())
            ->setName('RH')
        ;
        $manager->persist($object);

        $object = (new Profile())
            ->setName('Commercial')
        ;
        $manager->persist($object);

        $object = (new Profile())
            ->setName('Admin')
        ;
        $manager->persist($object);


        $manager->flush();
    }
}