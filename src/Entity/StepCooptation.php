<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\StepCooptationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepCooptationRepository::class)]
class StepCooptation
{

    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'stepCooptation', targetEntity: CooptationSteps::class)]
    private Collection $cooptationSteps;

    public function __construct()
    {
        $this->cooptationSteps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $cooptationStep->setStepCooptation($this);
        }

        return $this;
    }

    public function removeCooptationStep(CooptationSteps $cooptationStep): static
    {
        if ($this->cooptationSteps->removeElement($cooptationStep)) {
            // set the owning side to null (unless already changed)
            if ($cooptationStep->getStepCooptation() === $this) {
                $cooptationStep->setStepCooptation(null);
            }
        }

        return $this;
    }
}
