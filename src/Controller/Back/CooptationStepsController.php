<?php

namespace App\Controller\Back;

use App\Entity\CooptationSteps;
use App\Form\CooptationStepsType;
use App\Repository\CooptationRepository;
use App\Repository\CooptationStepsRepository;
use App\Repository\StepCooptationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cooptation/steps')]
class CooptationStepsController extends AbstractController
{
    #[Route('/', name: 'app_cooptation_steps_new', methods: ['POST'])]
    public function handleCooptationSteps(Request $request, CooptationStepsRepository $cooptationStepsRepository, CooptationRepository $cooptationRepository, StepCooptationRepository $stepCooptationRepository): Response
    {
        $data = $request->request->all();

        $cooptation = $cooptationRepository->find($data['cooptation_id']);
        $status = $data['status'];
        $stepCooptation = $stepCooptationRepository->find($data['step_cooptation_id']);

        $cooptationStep = new CooptationSteps();
        $cooptationStep->setCooptation($cooptation);
        $cooptationStep->setStepCooptation($stepCooptation);
        $cooptationStep->setStatus($status);
        $cooptationStepsRepository->save($cooptationStep, true);


        // Redirigez vers une autre page ou affichez un message de confirmation.
        return $this->redirectToRoute('back_app_cooptation_edit',['id' => $data['cooptation_id']]);
    }








}
