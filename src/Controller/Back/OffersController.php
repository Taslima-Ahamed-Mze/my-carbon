<?php

namespace App\Controller\Back;

use App\Entity\Offers;
use App\Form\OffersType;
use App\Repository\OffersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/offers')]
class OffersController extends AbstractController
{
    #[Route('/', name: 'app_offers_index', methods: ['GET'])]
    public function index(OffersRepository $offersRepository): Response
    {
        return $this->render('back/offers/index.html.twig', [
            'offers' => $offersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_offers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OffersRepository $offersRepository): Response
    {
        $offer = new Offers;
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offersRepository->save($offer, true);

            return $this->redirectToRoute('back_app_offers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/offers/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_offers_show', methods: ['GET'])]
    public function show(Offers $offer): Response
    {
        return $this->render('back/offers/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Security('user === offer.getCreatedBy() or is_granted("ROLE_ADMIN") or is_granted("ROLE_RH") or is_granted("ROLE_COMMERCIAL')]
    #[Route('/{id}/edit', name: 'app_offers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offers $offer, OffersRepository $offersRepository): Response
    {
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offersRepository->save($offer, true);

            return $this->redirectToRoute('back_app_offers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/offers/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Security('user === offer.getCreatedBy() or is_granted("ROLE_ADMIN") or is_granted("ROLE_COMMERCIAL") or is_granted("ROLE_RH")')]
    #[Route('/{id}', name: 'app_offers_delete', methods: ['POST'])]
    public function delete(Request $request, Offers $offer, OffersRepository $offersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getId(), $request->request->get('_token'))) {
            $offersRepository->remove($offer, true);
        }

        return $this->redirectToRoute('back_app_offers_index', [], Response::HTTP_SEE_OTHER);
    }
}
