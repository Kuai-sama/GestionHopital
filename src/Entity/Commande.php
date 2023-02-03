<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Fournisseur = null;

    #[ORM\Column]
    private ?int $Quantite = null;

    #[ORM\Column(length: 255)]
    private ?string $Etat = null;

    #[ORM\ManyToMany(targetEntity: Medicament::class, inversedBy: 'commandes')]
    private Collection $Medicament;

    public function __construct()
    {
        $this->Medicament = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFournisseur(): ?string
    {
        return $this->Fournisseur;
    }

    public function setFournisseur(string $Fournisseur): self
    {
        $this->Fournisseur = $Fournisseur;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->Quantite;
    }

    public function setQuantite(int $Quantite): self
    {
        $this->Quantite = $Quantite;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->Etat;
    }

    public function setEtat(string $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    /**
     * @return Collection<int, Medicament>
     */
    public function getMedicament(): Collection
    {
        return $this->Medicament;
    }

    public function addMedicament(Medicament $medicament): self
    {
        if (!$this->Medicament->contains($medicament)) {
            $this->Medicament->add($medicament);
        }

        return $this;
    }

    public function removeMedicament(Medicament $medicament): self
    {
        $this->Medicament->removeElement($medicament);

        return $this;
    }
}
