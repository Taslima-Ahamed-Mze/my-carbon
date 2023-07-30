<?php

namespace App\Controller\Back;

use App\Entity\Reward;
use App\Entity\User;
use App\Form\RewardType;
use App\Repository\RewardRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/reward')]
class RewardController extends AbstractController
{
    #[Route('/', name: 'app_reward_index', methods: ['GET'])]
    public function index(RewardRepository $rewardRepository, PaginatorInterface $paginator, Request $request, Security $security): Response
    {
        $pagination = $paginator->paginate(
            $rewardRepository->paginationQuery(),
            $request->query->get('page', 1),
            3
        );

        return $this->render('reward/index.html.twig', [
            'pagination' => $pagination,
            'user' => $security->getUser()
        ]);
    }

    #[Route('/new', name: 'app_reward_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reward = new Reward();
        $form = $this->createForm(RewardType::class, $reward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reward);
            $entityManager->flush();

            return $this->redirectToRoute('app_reward_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reward/new.html.twig', [
            'reward' => $reward,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reward_show', methods: ['GET'])]
    public function show(Reward $reward): Response
    {
        return $this->render('reward/show.html.twig', [
            'reward' => $reward,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reward_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reward $reward, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RewardType::class, $reward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reward_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reward/edit.html.twig', [
            'reward' => $reward,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/get', name: 'app_reward_get', methods: ['GET'])]
    public function getReward(Request $request, Reward $reward, UserRepository $userRepository, Security $security): Response
    {
        $user = $security->getUser();
        $user->setPoints($user->getPoints() - $reward->getPoints());
        $userRepository->save($user, true);

        return $this->redirectToRoute('back_app_reward_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}', name: 'app_reward_delete', methods: ['POST'])]
    public function delete(Request $request, Reward $reward, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reward->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reward);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reward_index', [], Response::HTTP_SEE_OTHER);
    }
}