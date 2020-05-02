<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="movie_order")
 */
class Order
{
    
    const STATUS_NEW = 'new';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PAID = 'paid';
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $status = self::STATUS_NEW;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     */
    protected $user;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Movie", inversedBy="orders")
     */
    protected $movies;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime;
    }
    
    public function __toString()
    {
        return sprintf('Zamówienie %d', $this->getId());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
     * Set user
     *
     * @param \App\Entity\User $user
     * @return MovieOrder
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

    /**
     * Add movie
     *
     * @param \App\Entity\Movie $movies
     * @return MovieOrder
     */
    public function addMovie(\App\Entity\Movie $movie)
    {
        $this->movies[] = $movie;

        return $this;
    }

    /**
     * Remove movie
     *
     * @param \App\Entity\Movie $movies
     */
    public function removeMovie(\App\Entity\Movie $movie)
    {
        $this->movies->removeElement($movie);
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovies()
    {
        return $this->movies;
    }
    
    public function isPaid()
    {
        return $this->status == self::STATUS_PAID;
    }
}
