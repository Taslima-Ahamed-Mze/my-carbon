<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Cooptation;
use App\Entity\Event;
use App\Entity\Formation;
use App\Entity\Invoice;
use App\Entity\Quotation;
use App\Entity\User;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Model\SendSmtpEmailAttachment;
use Twig\Environment;
use Symfony\Component\Asset\Package;

class Mailer
{
    private $sendinblueApi;
    private $twig;
    private $assetPackage;

    public function __construct(string $sendinblueApiKey, Environment $twig, Package $assetPackage)
    {
        $configuration = Configuration::getDefaultConfiguration()->setApiKey('api-key', $sendinblueApiKey);
        $this->sendinblueApi = new TransactionalEmailsApi(null, $configuration);
        $this->twig = $twig;
        $this->assetPackage = $assetPackage;
    }


    public function sendResetPasswordEmail(User $user, string $password): void
    {
        $htmlContent = $this->twig->render('back/email/send_reset_password.html.twig', [
            'plainPassword' => $password
        ]);

        $email = new SendSmtpEmail([
            'to' => [
                ['email' => $user->getEmail()]
            ],
            'subject' => 'Votre nouveau mot de passe',
            'htmlContent' => $htmlContent,
            'sender' => ['email' => 'devisio-challenge@gmail.com']
        ]);

        try {
            $this->sendinblueApi->sendTransacEmail($email);
        } catch (\Exception $e) {
            throw new \Exception('Failed to send email: ' . $e->getMessage());
        }
    }




    public function sendEmailEvent(User $user, Event $event): void
    {
        $htmlContent = $this->twig->render('back/email/event.html.twig', [
            'user' => $user,
            'event' => $event,
        ]);

        $email = new SendSmtpEmail([
            'to' => [
                ['email' => 'bastiendikiadi@outlook.fr']
            ],
            'subject' => 'Evenement',
            'htmlContent' => $htmlContent,
            'sender' => ['email' => 'test@test.fr'],
        ]);

        try {
            $this->sendinblueApi->sendTransacEmail($email);
        } catch (\Exception $e) {
            throw new \Exception('Failed to send email: ' . $e->getMessage());
        }
    }

    public function sendMailFormation(User $user, Formation $formation): void
    {
        $htmlContent = $this->twig->render('back/email/formation.html.twig', [
            'user' => $user,
            'formation' => $formation,
        ]);
        $email = new SendSmtpEmail([
            'to' => [
                ['email' => 'bastiendikiadi@outlook.fr']
            ],
            'subject' => 'Formation',
            'htmlContent' => $htmlContent,
            'sender' => ['email' => 'test@test.fr'],
        ]);

        try {
            $this->sendinblueApi->sendTransacEmail($email);
        } catch (\Exception $e) {
            throw new \Exception('Failed to send email: ' . $e->getMessage());
        }
    }

    public function sendMailSuccessCoptationCollaborator(User $user, Cooptation $cooptation): void
    {
        $htmlContent = $this->twig->render('back/email/cooptationSuccessCollaborator.html.twig', [
            'user' => $user,
            'cooptation' => $cooptation,
        ]);
        $email = new SendSmtpEmail([
            'to' => [
                ['email' => 'bastiendikiadi@outlook.fr']
            ],
            'subject' => 'Cooptation acceptée',
            'htmlContent' => $htmlContent,
            'sender' => ['email' => 'test@test.fr'],
        ]);

        try {
            $this->sendinblueApi->sendTransacEmail($email);
        } catch (\Exception $e) {
            throw new \Exception('Failed to send email: ' . $e->getMessage());
        }
    }

    public function sendMailSuccessCoptationCandidate(Cooptation $cooptation): void
    {
        $htmlContent = $this->twig->render('back/email/cooptationSuccessCandidate.html.twig', [
            'cooptation' => $cooptation,
        ]);
        $emailCandidate = $cooptation->getEmail();
        $email = new SendSmtpEmail([
            'to' => [
                ['email' => $emailCandidate]
            ],
            'subject' => 'Candidature acceptée',
            'htmlContent' => $htmlContent,
            'sender' => ['email' => 'test@test.fr'],
        ]);

        try {
            $this->sendinblueApi->sendTransacEmail($email);
        } catch (\Exception $e) {
            throw new \Exception('Failed to send email: ' . $e->getMessage());
        }
    }
}