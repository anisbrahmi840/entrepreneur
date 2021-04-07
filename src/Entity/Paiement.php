<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PaiementRepository::class)
 * @Vich\Uploadable
 */
class Paiement
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
    private $date_pai;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="paiement_image", fileNameProperty="image")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_ent = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat = false;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    public function __construct()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @ORM\OneToOne(targetEntity=Declaration::class, inversedBy="paiement", cascade={"persist", "remove"})
     */
    private $declaration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePai(): ?\DateTimeInterface
    {
        return $this->date_pai;
    }

    public function setDatePai(\DateTimeInterface $date_pai): self
    {
        $this->date_pai = $date_pai;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getEtatEnt(): ?bool
    {
        return $this->etat_ent;
    }

    public function setEtatEnt(bool $etat_ent): self
    {
        $this->etat_ent = $etat_ent;

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

    public function getDeclaration(): ?Declaration
    {
        return $this->declaration;
    }

    public function setDeclaration(Declaration $declaration): self
    {
        $this->declaration = $declaration;

        return $this;
    }


    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
}
