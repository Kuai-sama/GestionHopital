<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomSalle = null;

    #[ORM\Column]
    private ?int $EmplacementSalle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TypeSalle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSalle(): ?string
    {
        return $this->NomSalle;
    }

    public function setNomSalle(string $NomSalle): self
    {
        $this->NomSalle = $NomSalle;

        return $this;
    }

    public function getEmplacementSalle(): ?int
    {
        return $this->EmplacementSalle;
    }

    public function setEmplacementSalle(int $EmplacementSalle): self
    {
        $this->EmplacementSalle = $EmplacementSalle;

        return $this;
    }

    public function getTypeSalle(): ?string
    {
        return $this->TypeSalle;
    }

    public function setTypeSalle(?string $TypeSalle): self
    {
        $this->TypeSalle = $TypeSalle;

        return $this;
    }
}
