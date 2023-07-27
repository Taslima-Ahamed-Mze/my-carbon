<?php

namespace App\Entity;

use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
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
    private string $description;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Levels $level = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Skills $skill = null;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: FormationRegister::class)]
    private Collection $formationRegisters;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $videoUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $formationUrl = null;

    public function __construct()
    {
        $this->formationRegisters = new ArrayCollection();
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

    public function getLevel(): ?Levels
    {
        return $this->level;
    }

    public function setLevel(?Levels $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getSkill(): ?Skills
    {
        return $this->skill;
    }

    public function setSkill(?Skills $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection<int, FormationRegister>
     */
    public function getFormationRegisters(): Collection
    {
        return $this->formationRegisters;
    }

    public function addFormationRegister(FormationRegister $formationRegister): static
    {
        if (!$this->formationRegisters->contains($formationRegister)) {
            $this->formationRegisters->add($formationRegister);
            $formationRegister->setFormation($this);
        }

        return $this;
    }

    public function removeFormationRegister(FormationRegister $formationRegister): static
    {
        if ($this->formationRegisters->removeElement($formationRegister)) {
            // set the owning side to null (unless already changed)
            if ($formationRegister->getFormation() === $this) {
                $formationRegister->setFormation(null);
            }
        }

        return $this;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(string $videoUrl): static
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getFormationUrl(): ?string
    {
        return $this->formationUrl;
    }

    public function setFormationUrl(string $formationUrl): static
    {
        $this->formationUrl = $formationUrl;

        return $this;
    }
}