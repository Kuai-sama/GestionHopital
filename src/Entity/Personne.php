<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $NumSecuriteSociale = null;

    #[ORM\Column(nullable: true)]
    private ?int $NumAdeli = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column]
    private ?int $NumTel = null;

    #[ORM\Column(length: 255)]
    private ?string $MotDePasse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSecuriteSociale(): ?int
    {
        return $this->NumSecuriteSociale;
    }

    public function setNumSecuriteSociale(?int $NumSecuriteSociale): self
    {
        $this->NumSecuriteSociale = $NumSecuriteSociale;

        return $this;
    }

    public function getNumAdeli(): ?int
    {
        return $this->NumAdeli;
    }

    public function setNumAdeli(?int $NumAdeli): self
    {
        $this->NumAdeli = $NumAdeli;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->NumTel;
    }

    public function setNumTel(int $NumTel): self
    {
        $this->NumTel = $NumTel;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->MotDePasse;
    }

    public function setMotDePasse(string $MotDePasse): self
    {
        $this->MotDePasse = $MotDePasse;

        return $this;
    }
}
