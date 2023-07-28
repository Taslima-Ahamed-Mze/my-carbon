<?php

namespace App\Entity;

use App\Repository\EventRegisterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EventRegisterRepository::class)]
#[UniqueEntity(fields: ['collaborator_id', 'event_id'], message: 'Vous participez déja à cet événement')]
class EventRegister
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'eventRegisters')]
    private ?User $collaborator = null;

    #[ORM\ManyToOne(inversedBy: 'eventRegisters')]
    private ?Event $event = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCollaborator(): ?User
    {
        return $this->collaborator;
    }

    public function setCollaborator(?User $collaborator): static
    {
        $this->collaborator = $collaborator;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }
}