<?php

namespace App\Controller\Back;

use App\Repository\ContractsRepository;
use App\Repository\CooptationRepository;
use App\Repository\EventRegisterRepository;
use App\Repository\EventRepository;
use App\Repository\FormationRegisterRepository;
use App\Repository\FormationRepository;
use App\Repository\UserSkillsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_index', methods: ['GET'])]

    public function index(
        Security $security, ContractsRepository $contractsRepository, UserSkillsRepository $userSkillsRepository,
        EventRepository $eventRepository, FormationRepository $formationRepository, ChartBuilderInterface $chartBuilder,
        CooptationRepository $cooptationRepository, FormationRegisterRepository $formationRegisterRepository, EventRegisterRepository $eventRegisterRepository
    ): Response {
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
        usort($formations, function ($a, $b) {
            // Compare les IDs pour le tri (tri décroissant)
            return $b->getId() - $a->getId();
        });

        $threeFormations = array_slice($formations, 0, 3);

        $points = $security->getUser()->getPoints();


        $lastContract = $contractsRepository->findOneBy(
            ['id' => 50]
        );

        $cooptationsChart = $cooptationRepository->count([
            'createdBy' => $user
        ]);

        $formationsChart = $formationRegisterRepository->count([
            'collaborator' => $user
        ]);

        $eventChart = $eventRegisterRepository->count([
            'collaborator' => $user
        ]);

        $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);

        $chart->setData([
            'labels' => ['Cooptation crées', 'Formation suivies', 'Événement suivis'],
            'datasets' => [
                [
                    'label' => 'Mes activités',
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    'data' => [$cooptationsChart, $formationsChart, $cooptationsChart],
                ],
            ],
        ]);

        return $this->render('back/default/index.html.twig', [
            "user" => $user,
            "lastContract" => $lastContract,
            "formations" => $threeFormations,
            "events" => $events,
            'chart' => $chart
        ]);
    }
}