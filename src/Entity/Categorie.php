<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $codepostale;

    /**
     * @ORM\Column(type="boolean")
     */
    private $domicile;

    /**
     * @ORM\ManyToOne(targetEntity=Activite::class, inversedBy="categories")
     */
    private $activite;

    /**
     * @ORM\OneToOne(targetEntity=Entrepreneur::class, inversedBy="categorie", cascade={"persist", "remove"})
     */
    private $entrepreneur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodepostale(): ?int
    {
        return $this->codepostale;
    }

    public function setCodepostale(int $codepostale): self
    {
        $this->codepostale = $codepostale;

        return $this;
    }

    public function getDomicile(): ?bool
    {
        return $this->domicile;
    }

    public function setDomicile(bool $domicile): self
    {
        $this->domicile = $domicile;

        return $this;
    }

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setSlug(): string
    {
        $slug = new Slugify();
        return $this->slug = $slug->slugify($this->entrepreneur->getNom().'categorie'.date("dis"));
    }
}
