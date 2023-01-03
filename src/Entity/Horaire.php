<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRepository::class)]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Tdebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Tfin = null;

    #[ORM\ManyToOne(inversedBy: 'horaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personne $idPersonne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTdebut(): ?\DateTimeInterface
    {
        return $this->Tdebut;
    }

    public function setTdebut(\DateTimeInterface $Tdebut): self
    {
        $this->Tdebut = $Tdebut;

        return $this;
    }

    public function getTfin(): ?\DateTimeInterface
    {
        return $this->Tfin;
    }

    public function setTfin(?\DateTimeInterface $Tfin): self
    {
        $this->Tfin = $Tfin;

        return $this;
    }

    public function getIdPersonne(): ?Personne
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(?Personne $idPersonne): self
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }
}
