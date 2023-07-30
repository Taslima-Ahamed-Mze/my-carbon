<?php

namespace App\Controller\Back;

use App\Entity\Event;
use App\Entity\EventRegister;
use App\Form\EventType;
use App\Repository\EventRegisterRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


#[Route('/event')]
class EventController extends AbstractController
{
    private Mailer $mailer;
    private Security $security;

    public function __construct(Mailer $mailer, Security $security)
    {
        $this->mailer = $mailer;
        $this->security = $security;
    }

    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository, Request $request, PaginatorInterface $paginator, FlashyNotifier $flashy): Response
    {
        $pagination = $paginator->paginate(
            $eventRepository->paginationQuery(),
            $request->query->get('page', 1),
            4
        );
        
        $flashy->success('Event created!');

        return $this->render('event/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FlashyNotifier $flashy): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('back_app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event, EventRegisterRepository $eventRegisterRepository, Security $security ): Response
    {

        $isRegistered = $eventRegisterRepository->isUserRegistered($event, $security->getUser());
        return $this->render('event/show.html.twig', [
            'event' => $event,
            'isRegistered' => $isRegistered
        ]);
    }

    #[Security('user === event.getCreatedBy() or is_granted("ROLE_ADMIN") or is_granted("ROLE_COM")')]
    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Security('user === event.getCreatedBy() or is_granted("ROLE_ADMIN") or is_granted("ROLE_COM")')]
    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_app_event_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/register', name: 'app_event_register', methods: ['GET'])]
    public function registerEvent(Event $event, EventRegisterRepository $eventRegisterRepository, UserRepository $userRepository): Response
    {
        $collaborator = $this->security->getUser();
        $eventRegister = new EventRegister();
        $eventRegister->setCollaborator($collaborator);
        $eventRegister->setEvent($event);
        $eventRegisterRepository->save($eventRegister, true);

        $collaborator->setPoints($collaborator->getPoints() + 1);
        $userRepository->save($collaborator, true);

        $this->mailer->sendEmailEvent($collaborator, $event);

        return $this->redirectToRoute('back_app_event_show', ['id' => $event->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/unregister', name: 'app_event_unregister', methods: ['GET'])]
    public function unregisterEvent(Event $event, EventRegisterRepository $eventRegisterRepository, UserRepository $userRepository): Response
    {
        $collaborator = $this->security->getUser();
        $eventRegister = $eventRegisterRepository->findOneBy(['collaborator' => $collaborator, 'event' => $event]);

        if ($eventRegister) {
            $eventRegisterRepository->remove($eventRegister, true);
            $collaborator->setPoints($collaborator->getPoints() - 1);
            $userRepository->save($collaborator, true);
        }

        return $this->redirectToRoute('back_app_event_show', ['id' => $event->getId()], Response::HTTP_SEE_OTHER);
    }





}