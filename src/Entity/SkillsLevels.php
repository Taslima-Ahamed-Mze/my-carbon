<?php

namespace App\Entity;

use App\Repository\SkillsLevelsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillsLevelsRepository::class)]
class SkillsLevels
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skills $skill = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Levels $level = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLevel(): ?Levels
    {
        return $this->level;
    }

    public function setLevel(?Levels $level): static
    {
        $this->level = $level;

        return $this;
    }
}
