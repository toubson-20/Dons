<?php

namespace App\Entity;

use App\Repository\DonneurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonneurRepository::class)]
class Donneur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[ORM\Column(length: 50)]
    private ?string $sang = null;

    #[ORM\OneToMany(mappedBy: 'donneur', targetEntity: Dons::class)]
    private Collection $dons;

    #[ORM\OneToMany(mappedBy: 'donneur', targetEntity: Points::class)]
    private Collection $points;

    #[ORM\ManyToMany(targetEntity: Campagne::class, inversedBy: 'donneurs')]
    private Collection $campagne;

    public function __construct()
    {
        $this->dons = new ArrayCollection();
        $this->points = new ArrayCollection();
        $this->campagne = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getSang(): ?string
    {
        return $this->sang;
    }

    public function setSang(string $sang): self
    {
        $this->sang = $sang;

        return $this;
    }

    /**
     * @return Collection<int, Dons>
     */
    public function getDons(): Collection
    {
        return $this->dons;
    }

    public function addDon(Dons $don): self
    {
        if (!$this->dons->contains($don)) {
            $this->dons->add($don);
            $don->setDonneur($this);
        }

        return $this;
    }

    public function removeDon(Dons $don): self
    {
        if ($this->dons->removeElement($don)) {
            // set the owning side to null (unless already changed)
            if ($don->getDonneur() === $this) {
                $don->setDonneur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Points>
     */
    public function getPoints(): Collection
    {
        return $this->points;
    }

    public function addPoint(Points $point): self
    {
        if (!$this->points->contains($point)) {
            $this->points->add($point);
            $point->setDonneur($this);
        }

        return $this;
    }

    public function removePoint(Points $point): self
    {
        if ($this->points->removeElement($point)) {
            // set the owning side to null (unless already changed)
            if ($point->getDonneur() === $this) {
                $point->setDonneur(null);
            }
        }

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
