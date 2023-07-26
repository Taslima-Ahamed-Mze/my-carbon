<?php

namespace App\Controller\Back;

use App\Entity\Contracts;
use App\Form\ContractsType;
use App\Repository\ContractsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contracts')]
class ContractsController extends AbstractController
{
    #[Route('/', name: 'app_contracts_index', methods: ['GET'])]
    public function index(ContractsRepository $contractsRepository): Response
    {
        return $this->render('contracts/index.html.twig', [
            'contracts' => $contractsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contracts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contract = new Contracts();
        $form = $this->createForm(ContractsType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contract);
            $entityManager->flush();

            return $this->redirectToRoute('app_contracts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contracts/new.html.twig', [
            'contract' => $contract,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contracts_show', methods: ['GET'])]
    public function show(Contracts $contract): Response
    {
        return $this->render('contracts/show.html.twig', [
            'contract' => $contract,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contracts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contracts $contract, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContractsType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contracts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contracts/edit.html.twig', [
            'contract' => $contract,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contracts_delete', methods: ['POST'])]
    public function delete(Request $request, Contracts $contract, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contract->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contract);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contracts_index', [], Response::HTTP_SEE_OTHER);
    }
}
