<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

class PropertySearch
{

    #[ORM\ManyToOne]
    #[ORM\JoinColumn]
    private ?Skills $skill = null;

    public function getSkill(): ?Skills
    {
        return $this->skill;
    }

    public function setSkill(?Skills $skill): static
    {
        $this->skill = $skill;

        return $this;
    }


}