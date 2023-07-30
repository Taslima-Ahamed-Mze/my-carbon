<?php

namespace App\Controller\Back;

use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\SkillsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/skills')]
class SkillsController extends AbstractController
{
    #[Route('/', name: 'app_skills_index', methods: ['GET'])]
    public function index(SkillsRepository $skillsRepository): Response
    {
        return $this->render('back/skills/index.html.twig', [
            'skills' => $skillsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_skills_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        SkillsRepository $skillsRepository
        ): Response
    {
        $skill = new Skills();
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skillsRepository->save($skill, true);

            return $this->redirectToRoute(
                'back_app_skills_index', 
                [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/skills/new.html.twig', [
            'skills' => $skill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_skills_show', methods: ['GET'])]
    public function show(Skills $skills): Response
    {
        return $this->render('back/skills/show.html.twig', [
            'skills' => $skills,
        ]);
    }
    
    #[Security('user === skill.getCreatedBy() or is_granted("ROLE_ADMIN")')]
    #[Route('/{id}/edit', name: 'app_skills_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Skills $skills, SkillsRepository $skillsRepository): Response
    {
        $form = $this->createForm(SkillsType::class, $skills);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skillsRepository->save($skills, true);

            return $this->redirectToRoute('back_app_skills_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/skills/edit.html.twig', [
            'skills' => $skills,
            'form' => $form,
        ]);
    }

    #[Security('user === skill.getCreatedBy() or is_granted("ROLE_ADMIN")')]
    #[Route('/{id}', name: 'app_skills_delete', methods: ['POST'])]
    public function delete(Request $request, Skills $skills, SkillsRepository $skillsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skills->getId(), $request->request->get('_token'))) {
            $skillsRepository->remove($skills, true);
        }

        return $this->redirectToRoute('back_app_skills_index', [], Response::HTTP_SEE_OTHER);
    }
}