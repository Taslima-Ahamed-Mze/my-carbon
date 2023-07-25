<?php

namespace App\Entity;

use App\Repository\ContractsRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\TimestampableTrait;

#[ORM\Entity(repositoryClass: ContractsRepository::class)]
class Contracts
{ 
    use BlameableTrait;
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    private ?Offers $offer = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    private ?User $collaborator = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getOffer(): ?Offers
    {
        return $this->offer;
    }

    public function setOffer(?Offers $offer): static
    {
        $this->offer = $offer;

        return $this;
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
}
