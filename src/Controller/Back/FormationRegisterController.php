<?php

namespace App\Controller\Back;

use App\Entity\FormationRegister;
use App\Form\FormationRegisterType;
use App\Repository\FormationRegisterRepository;
use App\Repository\FormationRepository;
use App\Repository\LevelsRepository;
use App\Repository\UserRepository;
use App\Repository\UserSkillsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FormationRegisterController extends AbstractController
{
    #[Route('/register/formation', name: 'app_register_formation')]
    public function index(FormationRegisterRepository $formationRegisterRepository, Security $security, PaginatorInterface $paginator, Request $request): Response
    {

        $pagination = $paginator->paginate(
            $formationRegisterRepository->paginationQuery($security->getUser()),
            $request->query->get('page', 1),
            4
        );
    
        return $this->render('formation_register/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    // #[Route('/register/formation/finish/{/', name: 'app_finish_formation', methods: ['POST'])]
    // public function finishFormation(FormationRegister $formationRegister, FormationRegisterRepository $formationRegisterRepository, Security $security, Request $request,  EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(FormationRegisterType::class, $formationRegister);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('back_app_register_formation', [], Response::HTTP_SEE_OTHER);
    // }

    #[Route('/register/formation/certificate', name: 'app_register_formation_certificate')]
    public function certificate(FormationRegisterRepository $formationRegisterRepository): Response
    {
        $formationsRegister = $formationRegisterRepository->findNotNullCertificateNames();


        return $this->render('back/certificat/index.html.twig', [
            'formationsRegister' => $formationsRegister
        ]);
    }

    #[Route('/register/formation/certificate/validate', name: 'app_register_formation_certificate_validate', methods: ['POST'])]
    public function handleCooptationSteps(
        Request $request,
        UserRepository $userRepository,
        FormationRepository $formationRepository,
        FormationRegisterRepository $formationRegisterRepository,
        UserSkillsRepository $userSkillsRepository
    ): Response
    {

        $data = $request->request->all();

        $collaboratorId = $data['collaborator'];
        $formationId = $data['formation'];

        $collaborator = $userRepository->find($collaboratorId);
        $formation = $formationRepository->find($formationId);

        $levelFormation = $formation->getLevel();
        $skillFormation = $formation->getSkill();

        $userSkill = $userSkillsRepository->findBy([
            'collaborator' => $collaborator,
            'skill' => $skillFormation
        ]);

        if(count($userSkill) > 0){
            $userSkill[0]->setLevel($levelFormation);
            $userSkillsRepository->save($userSkill[0], true);
            $collaborator->setPoints($collaborator->getPoints() + 4);
            $userRepository->save($collaborator, true);
        }

        $formationRegister = $formationRegisterRepository->formationRegister($formation, $collaborator);
        $formationRegister->setStatus(true);
        $formationRegisterRepository->save($formationRegister, true);



        return $this->redirectToRoute('back_app_register_formation_certificate');
    }

}
