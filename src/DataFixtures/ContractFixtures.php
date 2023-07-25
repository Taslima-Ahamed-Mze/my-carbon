<?php

namespace App\DataFixtures;

use App\Entity\Contracts;
use App\Entity\Offers;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ContractFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();
        $offerRepository = $manager->getRepository(Offers::class);
        $offers = $offerRepository->findAll();



        for ($i = 0; $i < 50; $i++) {
            $randomUser = $users[array_rand($users)];
            $randomOffers = $offers[array_rand($offers)];

            $object = (new Contracts())
                ->setCreatedBy($randomUser)
                ->setOffer($randomOffers)
                ->setCollaborator($randomUser)

            ;

            $manager->persist($object);
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            OffersFixtures::class
        ];
    }
}