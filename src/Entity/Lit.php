<?php

namespace App\Entity;

use App\Repository\LitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LitRepository::class)]
class Lit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LitOccupe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLitOccupe(): ?bool
    {
        return $this->LitOccupe;
    }

    public function setLitOccupe(?bool $LitOccupe): self
    {
        $this->LitOccupe = $LitOccupe;

        return $this;
    }
}
