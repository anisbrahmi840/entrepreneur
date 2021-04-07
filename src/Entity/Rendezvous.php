<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RendezvousRepository;

/**
 * @ORM\Entity(repositoryClass=RendezvousRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Rendezvous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $daterendezvous;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objet;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Entrepreneur::class, inversedBy="rendezvouses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entrepreneur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observation;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="rendezvouses")
     */
    private $agent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDaterendezvous(): ?\DateTimeInterface
    {
        return $this->daterendezvous;
    }

    public function setDaterendezvous($daterendezvous): self
    {
        $this->daterendezvous = $daterendezvous;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setSlug()
    {
        $slug = new Slugify();
        return $this->slug = $slug->slugify($this->entrepreneur->getNom().$this->entrepreneur->getPrenom().$this->getDaterendezvous()->format('d-m-Y H:m'));
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

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }
}
