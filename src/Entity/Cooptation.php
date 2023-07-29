<?php

namespace App\Entity;

use App\Entity\Traits\BlameableTrait;
use App\Repository\CooptationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: CooptationRepository::class)]
#[Vich\Uploadable]
class Cooptation
{
    use BlameableTrait;
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;



    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'cooptation', targetEntity: CooptationSteps::class, cascade: ['all'], orphanRemoval: true )]
    private Collection $cooptationSteps;


    #[Vich\UploadableField(mapping: 'cooptations', fileNameProperty: 'cvName')]
    private ?File $cvFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cvName = null ;

    public function __construct()
    {
        $this->cooptationSteps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $Status): static
    {
        $this->status = $Status;

        return $this;
    }

    /**
     * @return Collection<int, CooptationSteps>
     */
    public function getCooptationSteps(): Collection
    {
        return $this->cooptationSteps;
    }

    public function addCooptationStep(CooptationSteps $cooptationStep): static
    {
        if (!$this->cooptationSteps->contains($cooptationStep)) {
            $this->cooptationSteps->add($cooptationStep);
            $cooptationStep->setCooptation($this);
        }

        return $this;
    }

    public function removeCooptationStep(CooptationSteps $cooptationStep): static
    {
        if ($this->cooptationSteps->removeElement($cooptationStep)) {
            // set the owning side to null (unless already changed)
            if ($cooptationStep->getCooptation() === $this) {
                $cooptationStep->setCooptation(null);
            }
        }

        return $this;
    }

    public function getCvName(): ?string
    {
        return $this->cvName;
    }

    public function setCvName(string $cvName): static
    {
        $this->cvName = $cvName;
        return $this;
    }

    public function setCvFile(?File $cvFile = null): void
    {
        $this->cvFile = $cvFile;

        if (null !== $cvFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }
    }

    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }
}
