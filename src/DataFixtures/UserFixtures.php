<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $pwd = 'test';

        $object = (new User())
            ->setEmail('user@user.fr')
            ->setLastname($faker->lastName())
            ->setFirstname($faker->firstName())
            ->setRoles(['ROLE_USER'])
            ->setPassword($pwd)
            ->setToken($faker->regexify('[A-Za-z0-9]{6}'))
            ->setCompanyName($faker->company())
            ->setPhoneNumber($faker->phoneNumber())
            ->setAddress($faker->address())
            ->setTvaNumber($faker->regexify('[A-Z]{2}[0-9]{2}[A-Z0-9]{9}'))
            ->setRib($faker->bothify('??###########?'))
        ;

        $manager->persist($object);

        $object = (new User())
            ->setEmail('admin@user.fr')
            ->setLastname($faker->lastName())
            ->setFirstname($faker->firstName())
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPassword($pwd)
            ->setToken($faker->regexify('[A-Za-z0-9]{6}'))
            ->setCompanyName($faker->company())
            ->setPhoneNumber($faker->phoneNumber())
            ->setAddress($faker->address())
            ->setTvaNumber($faker->regexify('[A-Z]{2}[0-9]{2}[A-Z0-9]{9}'))
            ->setRib($faker->bothify('??###########?'))
        ;

        $manager->persist($object);

        $manager->flush();
    }
}
