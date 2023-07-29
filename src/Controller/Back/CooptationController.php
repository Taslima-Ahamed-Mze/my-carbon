<?php

namespace App\Controller\Back;

use App\Entity\Cooptation;
use App\Entity\StepCooptation;
use App\Form\CooptationStepsType;
use App\Form\CooptationType;
use App\Repository\CooptationRepository;
use App\Repository\CooptationStepsRepository;
use App\Repository\StepCooptationRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/cooptation')]
class CooptationController extends AbstractController
{
    #[Route('/', name: 'app_cooptation_index', methods: ['GET'])]
    public function index(CooptationRepository $cooptationRepository): Response
    {
        return $this->render('back/cooptation/index.html.twig', [
            'cooptations' => $cooptationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cooptation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cooptation = new Cooptation();
        $form = $this->createForm(CooptationType::class, $cooptation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cooptation);
            $entityManager->flush();

            if(!$this->isGranted('ROLE_RH')){
                return $this->redirectToRoute('back_default_index', [], Response::HTTP_SEE_OTHER);
            }else{
                return $this->redirectToRoute('back_app_cooptation_index', [], Response::HTTP_SEE_OTHER);
            }

        }

        return $this->renderForm('back/cooptation/new.html.twig', [
            'cooptation' => $cooptation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cooptation_show', methods: ['GET'])]
    public function show(Cooptation $cooptation): Response
    {
        return $this->render('back/cooptation/show.html.twig', [
            'cooptation' => $cooptation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cooptation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cooptation $cooptation, EntityManagerInterface $entityManager, StepCooptationRepository $stepCooptationRepository, CooptationStepsRepository $cooptationStepsRepository): Response
    {
        /*$form = $this->createForm(CooptationStepsType::class, $cooptation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_app_cooptation_index', [], Response::HTTP_SEE_OTHER);
        }*/

        $displayStatus = [];

        $allStepCooptations = $stepCooptationRepository->findAll();

        foreach ($allStepCooptations as $stepCooptation){
            $cooptationStepVerify = $cooptationStepsRepository->findBy([
                'cooptation' => $cooptation,
                'stepCooptation' => $stepCooptation
            ]);

            if(count($cooptationStepVerify) > 0){
                $displayStatus[$stepCooptation->getName()] = $cooptationStepVerify[0]->getStatus();
            }else{
                $displayStatus[$stepCooptation->getName()] = null;
            }
        }

        //dd($allStepCooptations);




        return $this->render('back/cooptation/edit.html.twig', [
            'stepCooptations' => $allStepCooptations,
            'cooptation' => $cooptation,
            'displayStatus' =>$displayStatus

        ]);

        /*return $this->renderForm('back/cooptation/edit.html.twig', [
            'cooptation' => $cooptation,
            'form' => $form,
        ]);*/
    }

    #[Route('/{id}', name: 'app_cooptation_delete', methods: ['POST'])]
    public function delete(Request $request, Cooptation $cooptation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cooptation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cooptation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_app_cooptation_index', [], Response::HTTP_SEE_OTHER);
    }
}
