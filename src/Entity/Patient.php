<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Raison = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateHeureEntree = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateHeureSortie = null;

    #[ORM\OneToOne(inversedBy: 'patient', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personne $Personne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code_entre = null;

    #[ORM\ManyToOne(inversedBy: 'patients')]
    private ?Service $Service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaison(): ?string
    {
        return $this->Raison;
    }

    public function setRaison(string $Raison): self
    {
        $this->Raison = $Raison;

        return $this;
    }

    public function getDateHeureEntree(): ?\DateTimeInterface
    {
        return $this->DateHeureEntree;
    }

    public function setDateHeureEntree(\DateTimeInterface $DateHeureEntree): self
    {
        $this->DateHeureEntree = $DateHeureEntree;

        return $this;
    }

    public function getDateHeureSortie(): ?\DateTimeInterface
    {
        return $this->DateHeureSortie;
    }

    public function setDateHeureSortie(?\DateTimeInterface $DateHeureSortie): self
    {
        $this->DateHeureSortie = $DateHeureSortie;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->Personne;
    }

    public function setPersonne(Personne $Personne): self
    {
        $this->Personne = $Personne;

        return $this;
    }

    public function getCodeEntre(): ?string
    {
        return $this->code_entre;
    }

    public function setCodeEntre(?string $code_entre): self
    {
        $this->code_entre = $code_entre;

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
