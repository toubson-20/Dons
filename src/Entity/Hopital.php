<?php

namespace App\Entity;

use App\Repository\HopitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HopitalRepository::class)]
class Hopital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteWeb = null;

    #[ORM\OneToOne(inversedBy: 'departement', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dons $dons = null;

    #[ORM\ManyToOne(inversedBy: 'hopitals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departement $departement = null;

    #[ORM\ManyToMany(targetEntity: Campagne::class, inversedBy: 'hopitals')]
    private Collection $campagne;

    public function __construct()
    {
        $this->campagne = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->nom . ' ' . $this->adresse . ' ' . $this->telephone . ' ' . $this->siteWeb;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getDons(): ?Dons
    {
        return $this->dons;
    }

    public function setDons(Dons $dons): self
    {
        $this->dons = $dons;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection<int, Campagne>
     */
    public function getCampagne(): Collection
    {
        return $this->campagne;
    }

    public function addCampagne(Campagne $campagne): self
    {
        if (!$this->campagne->contains($campagne)) {
            $this->campagne->add($campagne);
        }

        return $this;
    }

    public function removeCampagne(Campagne $campagne): self
    {
        $this->campagne->removeElement($campagne);

        return $this;
    }
}
