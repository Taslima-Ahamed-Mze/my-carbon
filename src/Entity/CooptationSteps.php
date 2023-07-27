<?php

namespace App\Entity;

use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\CooptationStepsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CooptationStepsRepository::class)]
class CooptationSteps
{
    use BlameableTrait;
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cooptationSteps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cooptation $cooptation = null;

    #[ORM\ManyToOne(inversedBy: 'cooptationSteps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StepCooptation $stepCooptation = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCooptation(): ?Cooptation
    {
        return $this->cooptation;
    }

    public function setCooptation(?Cooptation $cooptation): static
    {
        $this->cooptation = $cooptation;

        return $this;
    }

    public function getStepCooptation(): ?StepCooptation
    {
        return $this->stepCooptation;
    }

    public function setStepCooptation(?StepCooptation $stepCooptation): static
    {
        $this->stepCooptation = $stepCooptation;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }



}
