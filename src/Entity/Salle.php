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
    private ?string $EmplacementSalle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TypeSalle = null;

    #[ORM\ManyToOne]
    private ?Service $Service = null;

    public function __toString(): string {
        return $this->getNomSalle();
    }

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

    public function getEmplacementSalle(): ?string
    {
        return $this->EmplacementSalle;
    }

    public function setEmplacementSalle(string $EmplacementSalle): self
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

    public function getService(): ?Service
    {
        return $this->Service;
    }

    public function setService(?Service $Service): self
    {
        $this->Service = $Service;

        return $this;
    }
}