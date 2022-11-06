<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $Email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?int $NumSecuriteSociale = null;

    #[ORM\Column(nullable: true)]
    private ?int $NumAdeli = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column]
    private ?string $NumTel = null;

    #[ORM\ManyToOne]
    private ?Lit $idLit = null;

    #[ORM\ManyToOne]
    private ?Metier $Metier = null;

    #[ORM\ManyToOne]
    private ?Service $Service = null;

    #[ORM\ManyToOne]
    private ?Diagnostic $Diagnostic = null;

    #[ORM\ManyToMany(targetEntity: Diagnostic::class)]
    private Collection $Diagnostiquer;

    #[ORM\OneToOne(mappedBy: 'Personne', cascade: ['persist', 'remove'])]
    private ?Patient $patient = null;

    #[ORM\ManyToMany(targetEntity: Prescription::class)]
    private Collection $Appliquer;

    public function __construct()
    {
        $this->Diagnostiquer = new ArrayCollection();
        $this->Appliquer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->Email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNumSecuriteSociale(): ?int
    {
        return $this->NumSecuriteSociale;
    }

    public function setNumSecuriteSociale(int $NumSecuriteSociale): self
    {
        $this->NumSecuriteSociale = $NumSecuriteSociale;

        return $this;
    }

    public function getNumAdeli(): ?int
    {
        return $this->NumAdeli;
    }

    public function setNumAdeli(int $NumAdeli): self
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

    public function getNumTel(): ?string
    {
        return $this->NumTel;
    }

    public function setNumTel(string $NumTel): self
    {
        $this->NumTel = $NumTel;

        return $this;
    }

    public function getIdLit(): ?Lit
    {
        return $this->idLit;
    }

    public function setIdLit(?Lit $idLit): self
    {
        $this->idLit = $idLit;

        return $this;
    }

    public function getMetier(): ?Metier
    {
        return $this->Metier;
    }

    public function setMetier(?Metier $Metier): self
    {
        $this->Metier = $Metier;

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

    public function getDiagnostic(): ?Diagnostic
    {
        return $this->Diagnostic;
    }

    public function setDiagnostic(?Diagnostic $Diagnostic): self
    {
        $this->Diagnostic = $Diagnostic;

        return $this;
    }

    /**
     * @return Collection<int, Diagnostic>
     */
    public function getDiagnostiquer(): Collection
    {
        return $this->Diagnostiquer;
    }

    public function addDiagnostiquer(Diagnostic $diagnostiquer): self
    {
        if (!$this->Diagnostiquer->contains($diagnostiquer)) {
            $this->Diagnostiquer->add($diagnostiquer);
        }

        return $this;
    }

    public function removeDiagnostiquer(Diagnostic $diagnostiquer): self
    {
        $this->Diagnostiquer->removeElement($diagnostiquer);

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): self
    {
        // set the owning side of the relation if necessary
        if ($patient->getPersonne() !== $this) {
            $patient->setPersonne($this);
        }

        $this->patient = $patient;

        return $this;
    }

    /**
     * @return Collection<int, Prescription>
     */
    public function getAppliquer(): Collection
    {
        return $this->Appliquer;
    }

    public function addAppliquer(Prescription $appliquer): self
    {
        if (!$this->Appliquer->contains($appliquer)) {
            $this->Appliquer->add($appliquer);
        }

        return $this;
    }

    public function removeAppliquer(Prescription $appliquer): self
    {
        $this->Appliquer->removeElement($appliquer);

        return $this;
    }
}