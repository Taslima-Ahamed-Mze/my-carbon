<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



#[ORM\Entity(repositoryClass: EventRepository::class)]
#[Vich\Uploadable]
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

    #[Vich\UploadableField(mapping: 'event', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(length:255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: EventRegister::class)]
    private Collection $eventRegisters;

    public function __construct()
    {
        $this->eventRegisters = new ArrayCollection();
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
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection<int, EventRegister>
     */
    public function getEventRegisters(): Collection
    {
        return $this->eventRegisters;
    }

    public function addEventRegister(EventRegister $eventRegister): static
    {
        if (!$this->eventRegisters->contains($eventRegister)) {
            $this->eventRegisters->add($eventRegister);
            $eventRegister->setEvent($this);
        }

        return $this;
    }

    public function removeEventRegister(EventRegister $eventRegister): static
    {
        if ($this->eventRegisters->removeElement($eventRegister)) {
            // set the owning side to null (unless already changed)
            if ($eventRegister->getEvent() === $this) {
                $eventRegister->setEvent(null);
            }
        }

        return $this;
    }
}
