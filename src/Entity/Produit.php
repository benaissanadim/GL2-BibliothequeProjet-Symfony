<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Utilities\TimeStampTrait;


/**
 * @ORM\Table(name="produit")
 * @ORM\Table(name="produit", indexes={@ORM\Index(columns={"name", "description"}, flags={"fulltext"})})
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Produit
{
    use TimeStampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="produits")
     */
    private $Category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path2;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="produit", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="Produit")
     */
    private $ratings;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $disponibility;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $StartDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ReturnDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ForSale;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $forBorrow;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getPath2(): ?string
    {
        return $this->path2;
    }

    public function setPath2(?string $path2): self
    {
        $this->path2 = $path2;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProduit($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProduit() === $this) {
                $comment->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setProduit($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getProduit() === $this) {
                $rating->setProduit(null);
            }
        }

        return $this;
    }

    public function getDisponibility(): ?bool
    {
        return $this->disponibility;
    }

    public function setDisponibility(?bool $disponibility): self
    {
        $this->disponibility = $disponibility;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->StartDate;
    }

    public function setStartDate(?\DateTimeInterface $StartDate): self
    {
        $this->StartDate = $StartDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->ReturnDate;
    }

    public function setReturnDate(?\DateTimeInterface $ReturnDate): self
    {
        $this->ReturnDate = $ReturnDate;

        return $this;
    }

    public function getForSale(): ?bool
    {
        return $this->ForSale;
    }

    public function setForSale(?bool $ForSale): self
    {
        $this->ForSale = $ForSale;

        return $this;
    }

    public function getForBorrow(): ?bool
    {
        return $this->forBorrow;
    }

    public function setForBorrow(?bool $forBorrow): self
    {
        $this->forBorrow = $forBorrow;

        return $this;
    }



}
