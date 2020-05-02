<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isModerated = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @var Movie
     * 
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="reviews")
     */
    protected $movie;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reviews")
     */
    protected $user;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime;
    }
    
    public function __toString()
    {
        return $this->getContent();
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

    public function getIsModerated(): ?bool
    {
        return $this->isModerated;
    }

    public function setIsModerated(bool $isModerated): self
    {
        $this->isModerated = $isModerated;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    
    /**
     * Set movie
     *
     * @param \App\Entity\Movie $movie
     * @return Review
     */
    public function setMovie(\App\Entity\Movie $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return \App\Entity\Movie 
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     * @return Review
     */
    public function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
