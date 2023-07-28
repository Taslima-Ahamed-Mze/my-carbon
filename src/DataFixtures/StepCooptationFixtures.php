<?php

namespace App\DataFixtures;

use App\Entity\Levels;
use App\Entity\StepCooptation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class StepCooptationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $object = (new StepCooptation())
            ->setName('CV');
        $manager->persist($object);

        $object = (new StepCooptation())
            ->setName('Entretien');
        $manager->persist($object);

        $object = (new StepCooptation())
            ->setName('Signature du Contrat');
        $manager->persist($object);

        $manager->flush();
    }


}

