<?php

namespace App\Entity;

use App\Repository\MetierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetierRepository::class)]
class Metier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomMetier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMetier(): ?string
    {
        return $this->NomMetier;
    }

    public function setNomMetier(string $NomMetier): self
    {
        $this->NomMetier = $NomMetier;

        return $this;
    }
}
