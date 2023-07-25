<?php

namespace App\DataFixtures;

use App\Entity\Levels;
use App\Entity\Skills;
use App\Entity\User;
use App\Entity\UserSkills;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserSkillsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();

        $skillRepository = $manager->getRepository(Skills::class);
        $skills = $skillRepository->findAll();

        $levelRepository = $manager->getRepository(Levels::class);
        $levels = $levelRepository->findAll();


        for ($i = 0; $i < 20; $i++) {
            $randomUser = $users[array_rand($users)];
            $randomSkills = $skills[array_rand($skills)];
            $randomLevels = $levels[array_rand($levels)];

            $object = (new UserSkills())
                ->setCollaborator($randomUser)
                ->setSkill($randomSkills)
                ->setLevel($randomLevels)
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

