<?php

namespace App\Service;

use App\Entity\Client;
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

    public function sendRegistrationTokenEmail(User $user): void
    {
        $htmlContent = $this->twig->render('back/email/send_token.html.twig', [
            'user' => $user
        ]);

        $email = new SendSmtpEmail([
            'to' => [
                ['email' => $user->getEmail()]
            ],
            'subject' => 'Votre code de vérification',
            'htmlContent' => $htmlContent,
            'sender' => ['email' => 'devisio-challenge@gmail.com']
        ]);

        try {
            if ($user->getSentEmailCounter() >= 3)
                throw new \Exception('Limite d\'envois de mail dépassée');

            $this->sendinblueApi->sendTransacEmail($email);
            $user->setSentEmailCounter($user->getSentEmailCounter() + 1);
        } catch (\Exception $e) {
            throw new \Exception('Failed to send email: ' . $e->getMessage());
        }
    }

    public function sendRegistrationConfirmationEmail(User $user): void
    {
        $htmlContent = $this->twig->render('back/email/send_confirmation.html.twig', [
            'user' => $user
        ]);

        $email = new SendSmtpEmail([
            'to' => [
                ['email' => $user->getEmail()]
            ],
            'subject' => 'Confirmation d\'inscription',
            'htmlContent' => $htmlContent,
            'sender' => ['email' => 'devisio-challenge@gmail.com']
        ]);

        try {
            $this->sendinblueApi->sendTransacEmail($email);
        } catch (\Exception $e) {
            throw new \Exception('Failed to send email: ' . $e->getMessage());
        }
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

    public function sendInvoiceEmail(User $user, Client $client, Invoice $invoice): void
    {

        $filePath = $this->assetPackage->getUrl('download/pdf/invoices/' . $invoice->getId() . '.pdf');
        $fileName = basename($filePath);
        $attachment = new SendSmtpEmailAttachment();
        $attachment->setName($fileName);
        $attachment->setContent(base64_encode(file_get_contents($filePath)));

        $htmlContent = $this->twig->render('back/email/send_invoice.html.twig', [
            'invoice' => $invoice,
            'client' => $client,
            'user' => $user
        ]);

        $email = new SendSmtpEmail([
            'to' => [
                ['email' => $client->getEmail()]
            ],
            'subject' => 'Votre facture',
            'htmlContent' => $htmlContent,
            'sender' => ['email' => $user->getEmail()],
            'attachment' => [$attachment]
        ]);

        try {
            $this->sendinblueApi->sendTransacEmail($email);
        } catch (\Exception $e) {
            throw new \Exception('Failed to send email: ' . $e->getMessage());
        }
    }

    public function sendQuotationEmail(User $user, Client $client, Quotation $quotation): void
    {

        $filePath = $this->assetPackage->getUrl('download/pdf/quotations/' . $quotation->getId() . '.pdf');
        $fileName = basename($filePath);
        $attachment = new SendSmtpEmailAttachment();
        $attachment->setName($fileName);
        $attachment->setContent(base64_encode(file_get_contents($filePath)));

        $htmlContent = $this->twig->render('back/email/send_quotation.html.twig', [
            'quotation' => $quotation,
            'client' => $client,
            'user' => $user
        ]);

        $email = new SendSmtpEmail([
            'to' => [
                ['email' => $client->getEmail()]
            ],
            'subject' => 'Votre devis',
            'htmlContent' => $htmlContent,
            'sender' => ['email' => $user->getEmail()],
            'attachment' => [$attachment]
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
}