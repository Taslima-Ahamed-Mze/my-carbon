<?php

namespace App\Controller\Back;

use App\Repository\ContractsRepository;
use App\Repository\InvoiceRepository;
use App\Repository\QuotationRepository;
use App\Repository\UserSkillsRepository;
use App\Service\DataRenderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_index', methods: ['GET'])]
    public function index(Security $security, ContractsRepository $contractsRepository, UserSkillsRepository $userSkillsRepository): Response
    {

        $user = $security->getUser();
        $lastContract = $contractsRepository->findOneBy(
            ['id' => 60]
        );

        
        return $this->render('back/default/index.html.twig', [
            "user" => $user,
            "lastContract" => $lastContract
        ]);
    }
}
