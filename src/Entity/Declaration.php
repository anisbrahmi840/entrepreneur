<?php

namespace App\Entity;

use App\Repository\DeclarationRepository;
use App\Repository\PaiementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeclarationRepository::class)
 */
class Declaration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true) 
     */
    private $chiffre;

    /**
     * @ORM\Column(type="date", nullable=true) 
     */
    private $date_dec;

    /**
     * @ORM\Column(type="date")
     */
    private $date_ex;

    /**
     * @ORM\Column(type="date", nullable=true) 
     */
    private $date_cr;

    /**
     * @ORM\Column(type="float", nullable=true) 
     */
    private $penalite;

    /**
     * @ORM\Column(type="float", nullable=true) 
     */
    private $cotisation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat = false;

    /**
     * @ORM\ManyToOne(targetEntity=Entrepreneur::class, inversedBy="declarations")
     */
    private $entrepreneur;

    /**
     * @ORM\Column(type="float", nullable=true) 
     */
    private $totalapayer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @ORM\OneToOne(targetEntity=Paiement::class, mappedBy="declaration", cascade={"persist", "remove"})
     */
    private $paiement;

    /**
     * @ORM\ManyToOne(targetEntity=AttestationChiffreAffaire::class, inversedBy="declaration")
     */
    private $attestationChiffreAffaire;

    /**
     * @ORM\ManyToOne(targetEntity=AttestationFiscale::class, inversedBy="declaration")
     */
    private $attestationFiscale;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChiffre(): ?float
    {
        return $this->chiffre;
    }

    public function setChiffre(?float $chiffre): self
    {
        $this->chiffre = $chiffre;

        return $this;
    }

    public function getDateDec(): ?\DateTimeInterface
    {
        return $this->date_dec;
    }

    public function setDateDec(\DateTimeInterface $date_dec): self
    {
        $this->date_dec = $date_dec;

        return $this;
    }

    public function getDateEx(): ?\DateTimeInterface
    {
        return $this->date_ex;
    }

    public function setDateEx(\DateTimeInterface $date_ex): self
    {
        $this->date_ex = $date_ex;

        return $this;
    }

    public function getDateCr(): ?\DateTimeInterface
    {
        return $this->date_cr;
    }

    public function setDateCr(\DateTimeInterface $date_cr): self
    {
        $this->date_cr = $date_cr;

        return $this;
    }

    public function getPenalite(): ?float
    {
        return $this->penalite;
    }

    public function setPenalite(float $penalite): self
    {
        $this->penalite = $penalite;

        return $this;
    }

    public function getCotisation(): ?float
    {
        return $this->cotisation;
    }

    public function setCotisation(float $cotisation): self
    {
        $this->cotisation = $cotisation;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

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

    public function getTotalapayer(): ?float
    {
        return $this->totalapayer;
    }

    public function setTotalapayer(float $totalapayer): self
    {
        $this->totalapayer = $totalapayer;

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

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(?Paiement $paiement): self
    {
        // unset the owning side of the relation if necessary
        if ($paiement === null && $this->paiement !== null) {
            $this->paiement->setdeclaration;
        }

        // set the owning side of the relation if necessary
        if ($paiement !== null && $paiement->getdeclaration() !== $this) {
            $paiement->setdeclaration($this);
        }

        $this->paiement = $paiement;

        return $this;
    }

    public function getAttestationChiffreAffaire(): ?AttestationChiffreAffaire
    {
        return $this->attestationChiffreAffaire;
    }

    public function setAttestationChiffreAffaire(?AttestationChiffreAffaire $attestationChiffreAffaire): self
    {
        $this->attestationChiffreAffaire = $attestationChiffreAffaire;

        return $this;
    }

    public function getAttestationFiscale(): ?AttestationFiscale
    {
        return $this->attestationFiscale;
    }

    public function setAttestationFiscale(?AttestationFiscale $attestationFiscale): self
    {
        $this->attestationFiscale = $attestationFiscale;

        return $this;
    }


}
