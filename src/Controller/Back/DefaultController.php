<?php

namespace App\Controller\Back;

use App\Repository\ContractsRepository;
use App\Repository\EventRepository;
use App\Repository\FormationRegisterRepository;
use App\Repository\FormationRepository;
use App\Repository\UserSkillsRepository;
use App\Service\DataRenderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_index', methods: ['GET'])]
    public function index(Security $security, ContractsRepository $contractsRepository, UserSkillsRepository $userSkillsRepository, EventRepository $eventRepository, FormationRepository $formationRepository): Response
    {
        $user = $security->getUser();
        $events = $eventRepository->findBy([], ['id' => 'DESC'], 3);
        $userSkills = $userSkillsRepository->findBy([
            'collaborator' => $user
        ]);
        $formations = [];

        foreach ($userSkills as $skill) {
            $formation = $formationRepository->findBy([
                'skill' => $skill->getSkill()
            ], [
                    'id' => 'DESC'
                ]);
        $formations = array_merge($formations, $formation);

        }
        usort($formations, function($a, $b) {
            // Compare les IDs pour le tri (tri décroissant)
            return $b->getId() - $a->getId();
        });

        $threeFormations = array_slice($formations, 0, 3);



        $lastContract = $contractsRepository->findOneBy(
            ['id' => 50]
        );

        return $this->render('back/default/index.html.twig', [
            "user" => $user,
            "lastContract" => $lastContract,
            "formations" => $threeFormations,
            "events" => $events
        ]);
    }
}