<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
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
    private $nicckname;

    /**
     * @ORM\Column(type="integer")
     */
    private $stars;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNicckname(): ?string
    {
        return $this->nicckname;
    }

    public function setNicckname(string $nicckname): self
    {
        $this->nicckname = $nicckname;

        return $this;
    }

    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(int $stars): self
    {
        $this->stars = $stars;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->Produit;
    }

    public function setProduit(?Produit $Produit): self
    {
        $this->Produit = $Produit;

        return $this;
    }
}
