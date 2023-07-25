<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\TimestampableTrait;


#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
   use BlameableTrait;
   use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: TypesEvents::class)]
    private Collection $typesEvents;

    public function __construct()
    {
        $this->typesEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection<int, TypesEvents>
     */
    public function getTypesEvents(): Collection
    {
        return $this->typesEvents;
    }

    public function addTypesEvent(TypesEvents $typesEvent): static
    {
        if (!$this->typesEvents->contains($typesEvent)) {
            $this->typesEvents->add($typesEvent);
            $typesEvent->setEvent($this);
        }

        return $this;
    }

    public function removeTypesEvent(TypesEvents $typesEvent): static
    {
        if ($this->typesEvents->removeElement($typesEvent)) {
            // set the owning side to null (unless already changed)
            if ($typesEvent->getEvent() === $this) {
                $typesEvent->setEvent(null);
            }
        }

        return $this;
    }
}
