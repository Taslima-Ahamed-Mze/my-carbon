<?php

namespace App\Controller\Back;

use App\Entity\FormationRegister;
use App\Form\FormationRegisterType;
use App\Repository\FormationRegisterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FormationRegisterController extends AbstractController
{
    #[Route('/register/formation', name: 'app_register_formation')]
    public function index(FormationRegisterRepository $formationRegisterRepository, Security $security): Response
    {
        $formations = $formationRegisterRepository->findBy([
            'collaborator' => $security->getUser()
        ]);



        return $this->render('formation_register/index.html.twig', [
            'formations' => $formations
        ]);
    }

    #[Route('/register/formation/finish/{collab}/{formation}', name: 'app_finish_formation', methods: ['POST'])]
    public function finishFormation(FormationRegister $formationRegister, FormationRegisterRepository $formationRegisterRepository, Security $security, Request $request,  EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormationRegisterType::class, $formationRegister);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_app_register_formation', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/register/formation/certificate', name: 'app_register_formation_certificate')]
    public function certificate(FormationRegisterRepository $formationRegisterRepository): Response
    {
        $formationsRegister = $formationRegisterRepository->findBy([
            'certificateName' => ['IS NOT NULL'],
        ]);



        return $this->render('back/certificat/index.html.twig', [
            'formationsRegister' => $formationsRegister
        ]);
    }

}
