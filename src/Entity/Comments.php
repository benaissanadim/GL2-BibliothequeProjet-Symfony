<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Utilities\TimeStampTrait;


/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Comments

{
    use TimeStampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nickname;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="parent")
     */
    private $replies;

    /**
     * @ORM\ManyToOne(targetEntity=Comments::class, inversedBy="replies")
     */
    private $parent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbStars;

    public function __construct()
    {
        $this->replies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(Comments $reply): self
    {
        if (!$this->replies->contains($reply)) {
            $this->replies[] = $reply;
            $reply->setParent($this);
        }

        return $this;
    }

    public function removeReply(Comments $reply): self
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getParent() === $this) {
                $reply->setParent(null);
            }
        }

        return $this;
    }


    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    public function getNbStars(): ?int
    {
        return $this->nbStars;
    }

    public function setNbStars(?int $nbStars): self
    {
        $this->nbStars = $nbStars;

        return $this;
    }
}
