<?php

namespace App\Entity;

use App\Repository\AttestationFiscaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttestationFiscaleRepository::class)
 */
class AttestationFiscale
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
    private $dateCr;

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

    /**
     * @ORM\ManyToOne(targetEntity=Entrepreneur::class, inversedBy="attestationFiscales")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entrepreneur;

    /**
     * @ORM\OneToMany(targetEntity=Declaration::class, mappedBy="attestationFiscale")
     */
    private $declaration;

    public function __construct()
    {
        $this->declaration = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCr(): ?\DateTimeInterface
    {
        return $this->dateCr;
    }

    public function setDateCr(\DateTimeInterface $dateCr): self
    {
        $this->dateCr = $dateCr;

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
            $declaration->setAttestationFiscale($this);
        }

        return $this;
    }

    public function removeDeclaration(Declaration $declaration): self
    {
        if ($this->declaration->removeElement($declaration)) {
            // set the owning side to null (unless already changed)
            if ($declaration->getAttestationFiscale() === $this) {
                $declaration->setAttestationFiscale(null);
            }
        }

        return $this;
    }
}
