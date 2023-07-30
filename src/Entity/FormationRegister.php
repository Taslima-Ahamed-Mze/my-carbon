<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\FormationRegisterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: FormationRegisterRepository::class)]
#[Vich\Uploadable]

class FormationRegister
{
    use TimestampableTrait; 
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'formationRegisters')]
    private ?User $collaborator = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'formationRegisters')]
    private ?Formation $formation = null;


    #[Vich\UploadableField(mapping: 'certificate', fileNameProperty: 'certificateName')]
    private ?File $certificateFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $certificateName = null;

    public function getCollaborator(): ?User
    {
        return $this->collaborator;
    }

    public function setCollaborator(?User $collaborator): static
    {
        $this->collaborator = $collaborator;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function setCertificateFile(?File $certificateFile = null): void
    {
        $this->certificateFile = $certificateFile;

        if (null !== $certificateFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }
    }

    public function getCertificateFile(): ?File
    {
        return $this->certificateFile;
    }

    public function setCertificateName(?string $certificateName): void
    {
        $this->certificateName = $certificateName;
    }

    public function getCertificateName(): ?string
    {
        return $this->certificateName;
    }

}