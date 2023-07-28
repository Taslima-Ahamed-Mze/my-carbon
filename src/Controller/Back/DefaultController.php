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
                ], 3);
        $formations = array_merge($formations, $formation);
        }

        $lastContract = $contractsRepository->findOneBy(
            ['id' => 50]
        );

        return $this->render('back/default/index.html.twig', [
            "user" => $user,
            "lastContract" => $lastContract,
            "formations" => $formations,
            "events" => $events
        ]);
    }
}