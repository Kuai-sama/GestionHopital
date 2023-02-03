<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomMedicament = null;

    #[ORM\Column(length: 255)]
    private ?string $Forme = null;

    #[ORM\Column(nullable: true)]
    private ?int $Stock = null;

    #[ORM\ManyToMany(targetEntity: Commande::class)]
    private Collection $Commander;

    public function __construct()
    {
        $this->Commander = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMedicament(): ?string
    {
        return $this->NomMedicament;
    }

    public function setNomMedicament(string $NomMedicament): self
    {
        $this->NomMedicament = $NomMedicament;

        return $this;
    }

    public function getForme(): ?string
    {
        return $this->Forme;
    }

    public function setForme(string $Forme): self
    {
        $this->Forme = $Forme;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(?int $Stock): self
    {
        $this->Stock = $Stock;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommander(): Collection
    {
        return $this->Commander;
    }

    public function addCommander(Commande $commander): self
    {
        if (!$this->Commander->contains($commander)) {
            $this->Commander->add($commander);
        }

        return $this;
    }

    public function removeCommander(Commande $commander): self
    {
        $this->Commander->removeElement($commander);

        return $this;
    }

    public function __toString(): string{
        return $this->getNomMedicament();
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addMedicament($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeMedicament($this);
        }

        return $this;
    }
}
