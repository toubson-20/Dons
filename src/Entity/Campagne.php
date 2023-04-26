<?php

namespace App\Entity;

use App\Repository\CampagneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
class Campagne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(length: 300)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Hopital::class, mappedBy: 'campagne')]
    private Collection $hopitals;

    #[ORM\ManyToMany(targetEntity: Donneur::class, mappedBy: 'campagne')]
    private Collection $donneurs;

    public function __construct()
    {
        $this->hopitals = new ArrayCollection();
        $this->donneurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Hopital>
     */
    public function getHopitals(): Collection
    {
        return $this->hopitals;
    }

    public function addHopital(Hopital $hopital): self
    {
        if (!$this->hopitals->contains($hopital)) {
            $this->hopitals->add($hopital);
            $hopital->addCampagne($this);
        }

        return $this;
    }

    public function removeHopital(Hopital $hopital): self
    {
        if ($this->hopitals->removeElement($hopital)) {
            $hopital->removeCampagne($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Donneur>
     */
    public function getDonneurs(): Collection
    {
        return $this->donneurs;
    }

    public function addDonneur(Donneur $donneur): self
    {
        if (!$this->donneurs->contains($donneur)) {
            $this->donneurs->add($donneur);
            $donneur->addCampagne($this);
        }

        return $this;
    }

    public function removeDonneur(Donneur $donneur): self
    {
        if ($this->donneurs->removeElement($donneur)) {
            $donneur->removeCampagne($this);
        }

        return $this;
    }
}
