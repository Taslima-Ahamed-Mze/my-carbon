<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Levels;
use App\Entity\Skills;


class FormationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();

        $skillRepository = $manager->getRepository(Skills::class);
        $skills = $skillRepository->findAll();

        $levelRepository = $manager->getRepository(Levels::class);
        $levels = $levelRepository->findAll();



        for ($i = 0; $i < 40; $i++) {
            $randomUser = $users[array_rand($users)];
            $randomSkills = $skills[array_rand($skills)];
            $randomLevels = $levels[array_rand($levels)];

            $object = (new Formation())
                ->setTitle($faker->title())
                ->setDescription($faker->sentence(80))
                ->setImageUrl($faker->imageUrl())
                ->setFormationUrl($faker->url())
                ->setLevel($randomLevels)
                ->setSkill($randomSkills)
                ->setCreatedBy($randomUser);
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SkillsFixtures::class,
            LevelsFixtures::class
        ];
    }

}