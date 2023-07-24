<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/login')]
class LoginController extends AbstractController
{

    private Mailer $mailer;
    private UserRepository $userRepository;

    public function __construct(Mailer $mailer, UserRepository $userRepository)
    {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
    }

    #[Route('/reset-password', name: 'app_reset_password')]
    public function resetPassword(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            $user = $this->userRepository->findOneBy(['email' => $email]);

            if ($user) {
                $randomPassword = $this->generateRandomPassword();
                $user->setPassword($randomPassword);

                $entityManager->persist($user);
                $entityManager->flush();

                $this->mailer->sendResetPasswordEmail($user, $randomPassword);
                
                $success = 'Vous avez reçu un email avec votre nouveau mot de passe.';
                return $this->renderForm('front/login/reset_password.html.twig', [
                    'form' => $form,
                    'success' => $success
                ]);
            } else {
                $error = 'L\'email renseigné ne correspond à aucun compte.';
                return $this->renderForm('front/login/reset_password.html.twig', [
                    'form' => $form,
                    'error' => $error
                ]);
            }
        }

        return $this->renderForm('front/login/reset_password.html.twig', [
            'form' => $form,
        ]);
    }

    private function generateRandomPassword(int $length = 10): string
    {
        // Génère un mot de passe aléatoire avec des caractères alphanumériques
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomPassword = '';

        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $randomPassword;
    }
}
