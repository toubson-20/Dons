<?php

namespace App\Entity;

use App\Repository\PointsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointsRepository::class)]
class Points
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $code = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'points')]
    private ?Donneur $donneur = null;

    #[ORM\OneToOne(mappedBy: 'points', cascade: ['persist', 'remove'])]
    private ?Dons $dons = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDonneur(): ?Donneur
    {
        return $this->donneur;
    }

    public function setDonneur(?Donneur $donneur): self
    {
        $this->donneur = $donneur;

        return $this;
    }

    public function getDons(): ?Dons
    {
        return $this->dons;
    }

    public function setDons(?Dons $dons): self
    {
        // unset the owning side of the relation if necessary
        if ($dons === null && $this->dons !== null) {
            $this->dons->setPoints(null);
        }

        // set the owning side of the relation if necessary
        if ($dons !== null && $dons->getPoints() !== $this) {
            $dons->setPoints($this);
        }

        $this->dons = $dons;

        return $this;
    }
}
