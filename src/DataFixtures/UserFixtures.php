<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $pwd = 'test';

        $profileRepository = $manager->getRepository(Profile::class);
        $profiles = $profileRepository->findAll();



        $object = (new User())
            ->setEmail('user@user.fr')
            ->setLastname($faker->lastName())
            ->setFirstname($faker->firstName())
            ->setRoles(['ROLE_COLLABORATOR'])
            ->setPlainPassword($pwd)
            ->setProfile($profiles[0])
            ->setPoints(1)
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('com@user.fr')
            ->setLastname($faker->lastName())
            ->setFirstname($faker->firstName())
            ->setRoles(['ROLE_COM'])
            ->setPlainPassword($pwd)
            ->setProfile($profiles[1])

        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('comer@user.fr')
            ->setLastname($faker->lastName())
            ->setFirstname($faker->firstName())
            ->setRoles(['ROLE_COMMERCIAL'])
            ->setPlainPassword($pwd)
            ->setProfile($profiles[3])

        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('rh@user.fr')
            ->setLastname($faker->lastName())
            ->setFirstname($faker->firstName())
            ->setRoles(['ROLE_RH'])
            ->setPlainPassword($pwd)
            ->setProfile($profiles[2])

        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('admin@user.fr')
            ->setLastname($faker->lastName())
            ->setFirstname($faker->firstName())
            ->setRoles(['ROLE_ADMIN'])
            ->setPlainPassword($pwd)
            ->setProfile($profiles[4])
            ->setPoints(1)
        ;

        $manager->persist($object);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProfileFixtures::class
        ];
    }
}