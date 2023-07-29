<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\SkillsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_RH") or is_granted("ROLE_COMMERCIAL")')]
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('back/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_RH") or is_granted("ROLE_COMMERCIAL")')]
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        UserRepository $userRepository
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
        ]);
        $form->handleRequest($request);
        $profile = $form->get('profile')->getData();

       if ($form->isSubmitted() && $form->isValid()) {
           //dd($request);
           switch ($profile->getName()){
                case 'Collaborateur':
                    $user->setRoles(['ROLE_COLLABORATOR']);
                break;
                case 'RH':
                    $user->setRoles(['ROLE_RH']);
                break;
                case 'Commercial':
                    $user->setRoles(['ROLE_COMMERCIAL']);
                break;
                case 'Admin':
                    $user->setRoles(['ROLE_ADMIN']);
                break;
                case 'Communication':
                    $user->setRoles(['ROLE_COM']);
                break;
                default:
                    $user->setRoles(['ROLE_ADMIN']);

            }
            $userRepository->save($user, true);

            return $this->redirectToRoute(
                'back_app_user_index',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_RH") or is_granted("ROLE_COMMERCIAL")')]
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(UserType::class, $user, [
            'back_edit' => true,
            'validation_groups' => ['Default', 'edit'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $currentPassword = $entityManager->getUnitOfWork()->getOriginalEntityData($user)['password'];
            dd($currentPassword);
            if ($user->getPlainPassword()) {
                $user->setPassword($user->getPlainPassword());
            }
            $userRepository->save($user, true);
            return $this->redirectToRoute(
                'back_app_user_index',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_RH") or is_granted("ROLE_COMMERCIAL")')]
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        User $user,
        UserRepository $userRepository
    ): Response {
        if (
            $this->isCsrfTokenValid(
                'delete' . $user->getId(),
                $request->request->get('_token')
            )
        ) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute(
            'back_app_user_index',
            [],
            Response::HTTP_SEE_OTHER
        );
    }
}
