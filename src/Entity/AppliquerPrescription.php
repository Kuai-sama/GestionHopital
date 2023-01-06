<?php

namespace App\Entity;

use App\Repository\AppliquerPrescriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppliquerPrescriptionRepository::class)]
class AppliquerPrescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'appliquerPrescriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personne $patient = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prescription $Prescription = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateHeureApplication = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Personne $Soignant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Personne
    {
        return $this->patient;
    }

    public function setPatient(?Personne $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getPrescription(): ?Prescription
    {
        return $this->Prescription;
    }

    public function setPrescription(?Prescription $Prescription): self
    {
        $this->Prescription = $Prescription;

        return $this;
    }

    public function getDateHeureApplication(): ?\DateTimeInterface
    {
        return $this->DateHeureApplication;
    }

    public function setDateHeureApplication(\DateTimeInterface $DateHeureApplication): self
    {
        $this->DateHeureApplication = $DateHeureApplication;

        return $this;
    }

    public function getSoignant(): ?Personne
    {
        return $this->Soignant;
    }

    public function setSoignant(?Personne $Soignant): self
    {
        $this->Soignant = $Soignant;

        return $this;
    }
}
