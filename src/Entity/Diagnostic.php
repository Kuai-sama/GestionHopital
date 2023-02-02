<?php

namespace App\Entity;

use App\Repository\DiagnosticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiagnosticRepository::class)]
class Diagnostic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Diagnostic = null;

    #[ORM\ManyToMany(targetEntity: Personne::class, mappedBy: 'Diagnostic')]
    private Collection $Diagno_patient_personne;

    public function __construct()
    {
        $this->Diagno_patient_personne = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiagnostic(): ?string
    {
        return $this->Diagnostic;
    }

    public function setDiagnostic(string $Diagnostic): self
    {
        $this->Diagnostic = $Diagnostic;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getDiagnoPatientPersonne(): Collection
    {
        return $this->Diagno_patient_personne;
    }

    public function addDiagnoPatientPersonne(Personne $diagnoPatientPersonne): self
    {
        if (!$this->Diagno_patient_personne->contains($diagnoPatientPersonne)) {
            $this->Diagno_patient_personne->add($diagnoPatientPersonne);
            $diagnoPatientPersonne->addDiagnostic($this);
        }

        return $this;
    }

    public function removeDiagnoPatientPersonne(Personne $diagnoPatientPersonne): self
    {
        if ($this->Diagno_patient_personne->removeElement($diagnoPatientPersonne)) {
            $diagnoPatientPersonne->removeDiagnostic($this);
        }

        return $this;
    }
}
