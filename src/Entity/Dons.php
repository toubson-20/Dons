<?php

namespace App\Entity;

use App\Repository\DonsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonsRepository::class)]
class Dons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\OneToOne(mappedBy: 'dons', cascade: ['persist', 'remove'])]
    private ?Hopital $hopital = null;

    #[ORM\ManyToOne(inversedBy: 'dons')]
    private ?Donneur $donneur = null;

    #[ORM\OneToOne(inversedBy: 'dons', cascade: ['persist', 'remove'])]
    private ?Points $points = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function gethopital(): ?Hopital
    {
        return $this->hopital;
    }

    public function sethopital(Hopital $hopital): self
    {
        // set the owning side of the relation if necessary
        if ($hopital->getDons() !== $this) {
            $hopital->setDons($this);
        }

        $this->hopital = $hopital;

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

    public function getPoints(): ?Points
    {
        return $this->points;
    }

    public function setPoints(?Points $points): self
    {
        $this->points = $points;

        return $this;
    }
}
