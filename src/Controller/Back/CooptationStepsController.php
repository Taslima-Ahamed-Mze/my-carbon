<?php

namespace App\Controller\Back;

use App\Entity\CooptationSteps;
use App\Form\CooptationStepsType;
use App\Repository\CooptationRepository;
use App\Repository\CooptationStepsRepository;
use App\Repository\StepCooptationRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cooptation/steps')]
class CooptationStepsController extends AbstractController
{

    private Mailer $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/', name: 'app_cooptation_steps_new', methods: ['POST'])]
    public function handleCooptationSteps(
        Request $request,
        CooptationStepsRepository $cooptationStepsRepository,
        CooptationRepository $cooptationRepository,
        StepCooptationRepository $stepCooptationRepository,
        SessionInterface $session,
        UserRepository $userRepository
    ): Response
    {
        $availableStepCooptations = $stepCooptationRepository->findAll();

        $validStepCooptations = [];
        foreach ($availableStepCooptations as $stepCooptation) {
            $validStepCooptations[] = $stepCooptation->getId();
        }

        $data = $request->request->all();
        $stepCooptationId = $data['step_cooptation_id'];
        $stepCooptation = $stepCooptationRepository->find($data['step_cooptation_id']);
        $cooptation = $cooptationRepository->find($data['cooptation_id']);
        $collaborator = $cooptation->getCreatedBy();
        $status = $data['status'];

        if ($stepCooptationId == $validStepCooptations[0] || $cooptationStepsRepository->hasPreviousSteps($cooptation, $stepCooptation) ) {

            $cooptationStep = new CooptationSteps();
            $cooptationStep->setCooptation($cooptation);
            $cooptationStep->setStepCooptation($stepCooptation);
            $cooptationStep->setStatus($status);
            $cooptationStepsRepository->save($cooptationStep, true);

            if($stepCooptationId == end($validStepCooptations) && $status == 'validated'){
                $this->mailer->sendMailSuccessCoptationCollaborator($collaborator, $cooptation);
                $this->mailer->sendMailSuccessCoptationCandidate($cooptation);
                $collaborator->setPoints(10);
                $userRepository->save($collaborator, true);



            }
        } else {
            $session->getFlashBag()->add('error', 'Veuillez valider les étapes par ordre');

        }

        // Redirigez vers une autre page ou affichez un message de confirmation.
        return $this->redirectToRoute('back_app_cooptation_edit',['id' => $data['cooptation_id']]);
    }








}
