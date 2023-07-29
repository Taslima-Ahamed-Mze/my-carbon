<?php

namespace App\Controller\Back;

use App\Entity\Formation;
use App\Entity\FormationRegister;
use App\Entity\PropertySearch;
use App\Form\FormationType;
use App\Form\PropertySearchType;
use App\Repository\FormationRegisterRepository;
use App\Repository\FormationRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


#[Route('/formation')]
class FormationController extends AbstractController
{
    private Mailer $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/', name: 'app_formation_index', methods: ['GET'])]
    public function index(FormationRepository $formationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        $pagination = $paginator->paginate(
            $formationRepository->paginationQuery($search),
            $request->query->get('page', 1),
            4
        );

        return $this->render('formation/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);

    }

    #[Route('/new', name: 'app_formation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formation_show', methods: ['GET'])]
    public function show(Formation $formation, FormationRegisterRepository $formationRegisterRepository, Security $security): Response
    {
        $collaborator = $security->getUser();
        $isRegistered = $formationRegisterRepository->isUserRegistered($formation, $collaborator);

        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
            'isRegistered' => $isRegistered
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formation_delete', methods: ['POST'])]
    public function delete(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $formation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/register', name: 'app_formation_register', methods: ['GET'])]
    public function registerFormation(Formation $formation, FormationRegisterRepository $formationRegisterRepository, Security $security, UserRepository $userRepository): Response
    {
        $collaborator = $security->getUser();
        $formationRegister = new FormationRegister();
        $formationRegister->setCollaborator($collaborator);
        $formationRegister->setFormation($formation);
        $formationRegisterRepository->save($formationRegister, true);

        $collaborator->setPoints($collaborator->getPoints() + 1);
        $userRepository->save($collaborator, true);

        $this->mailer->sendMailFormation($security->getUser(), $formation);

        return $this->redirectToRoute('back_app_formation_show', ['id' => $formation->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/unregister', name: 'app_formation_unregister', methods: ['GET'])]
    public function unregisterFormation(Formation $formation, FormationRegisterRepository $formationRegisterRepository, Security $security, UserRepository $userRepository): Response
    {
        $collaborator = $security->getUser();
        $formationRegister = $formationRegisterRepository->findOneBy(['collaborator' => $collaborator , 'formation' => $formation]);

        if ($formationRegister) {
            $formationRegisterRepository->remove($formationRegister, true);
            $collaborator->setPoints($collaborator->getPoints() - 1);
            $userRepository->save($collaborator, true);
        }

        return $this->redirectToRoute('back_app_formation_show', ['id' => $formation->getId()], Response::HTTP_SEE_OTHER);
    }
}