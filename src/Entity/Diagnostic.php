<?php

namespace App\Entity;

use App\Repository\DiagnosticRepository;
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
}
