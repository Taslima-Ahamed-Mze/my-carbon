<?php

namespace App\Controller\Back;

use App\Entity\Cooptation;
use App\Entity\Event;
use App\Entity\EventRegister;
use App\Entity\Formation;
use App\Entity\FormationRegister;
use App\Repository\CooptationRepository;
use App\Repository\EventRegisterRepository;
use App\Repository\FormationRegisterRepository;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MailerController extends AbstractController
{
    #[Route('/event/email/{id}', name: 'app_event_mail', methods: ['GET'])]
    public function sendEmailEvent(Mailer $mailer, EventRegisterRepository $eventRegisterRepository, Security $security, Event $event): Response
    {

        $eventRegister = new EventRegister();

        $eventRegister->setCollaborator($security->getUser());
        $eventRegister->setEvent($event);

        $eventRegisterRepository->save($eventRegister, true);

        $mailer->sendEmailEvent($security->getUser(), $event);


        return $this->redirectToRoute('back_app_event_index', [], Response::HTTP_SEE_OTHER);
        // ...
    }

    #[Route('/formation/email/{id}', name: 'app_formation_mail', methods: ['GET'])]
    public function sendMailFormation(Mailer $mailer, FormationRegisterRepository $formationRegisterRepository, Security $security, Formation $formation): Response
    {

        $formationRegister = new FormationRegister();

        $formationRegister->setCollaborator($security->getUser());
        $formationRegister->setFormation($formation);

        $formationRegisterRepository->save($formationRegister, true);

        $mailer->sendMailFormation($security->getUser(), $formation);


        return $this->redirectToRoute('back_app_formation_index', [], Response::HTTP_SEE_OTHER);
        // ...
    }

    #[Route('/cooptation/success/email/{id}', name: 'app_cooptation_success_mail', methods: ['GET'])]
    public function sendMailSuccessCooptationCollaborator(Mailer $mailer, Cooptation $cooptation): Response
    {

        $collaborator = $cooptation->getCreatedBy();
        $mailer->sendMailSuccessCoptationCollaborator($collaborator, $cooptation);

        return $this->redirectToRoute('back_app_cooptation_index', [], Response::HTTP_SEE_OTHER);
        // ...
    }

    #[Route('/cooptation/success/candidate/email/{id}', name: 'app_cooptation_success_candidate_mail', methods: ['GET'])]
    public function sendMailSuccessCooptationCandidate(Mailer $mailer, Cooptation $cooptation): Response
    {
        $mailer->sendMailSuccessCoptationCandidate( $cooptation);

        return $this->redirectToRoute('back_app_cooptation_index', [], Response::HTTP_SEE_OTHER);
        // ...
    }
}