<?php

namespace App\Entity;

use App\Repository\AttestationChiffreAffaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttestationChiffreAffaireRepository::class)
 */
class AttestationChiffreAffaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Entrepreneur::class, inversedBy="attestationChiffreAffaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entrepreneur;

    /**
     * @ORM\OneToMany(targetEntity=Declaration::class, mappedBy="attestationChiffreAffaire")
     */
    private $declaration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $annee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    public function __construct()
    {
        $this->declaration = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEntrepreneur(): ?Entrepreneur
    {
        return $this->entrepreneur;
    }

    public function setEntrepreneur(?Entrepreneur $entrepreneur): self
    {
        $this->entrepreneur = $entrepreneur;

        return $this;
    }

    /**
     * @return Collection|Declaration[]
     */
    public function getDeclaration(): Collection
    {
        return $this->declaration;
    }

    public function addDeclaration(Declaration $declaration): self
    {
        if (!$this->declaration->contains($declaration)) {
            $this->declaration[] = $declaration;
            $declaration->setAttestationChiffreAffaire($this);
        }

        return $this;
    }

    public function removeDeclaration(Declaration $declaration): self
    {
        if ($this->declaration->removeElement($declaration)) {
            // set the owning side to null (unless already changed)
            if ($declaration->getAttestationChiffreAffaire() === $this) {
                $declaration->setAttestationChiffreAffaire(null);
            }
        }

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
