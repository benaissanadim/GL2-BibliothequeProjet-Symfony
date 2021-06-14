<?php

namespace App\Entity\Newsletters;

use App\Repository\Newsletters\NewslettersRepository;
use App\Utilities\TimeStampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewslettersRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Newsletters
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
     * @ORM\Column(type="text")
     */
    private $content;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbofsent;



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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }



    public function getNbofsent(): ?int
    {
        return $this->nbofsent;
    }

    public function setNbofsent(?int $nbofsent): self
    {
        $this->nbofsent = $nbofsent;

        return $this;
    }


}
