<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $actores;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="nb_orders", type="integer")
     */
    private $nbOrders = 0;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nb_reviews", type="integer")
     */
    private $nbReviews = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @var ArrayCollection
     *
     * * @ORM\OneToMany(targetEntity="Review", mappedBy="movie")
     */
    protected $reviews;

    /**
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="movies")
     */
    protected $categories;
    
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Order", mappedBy="movies")
     */
    protected $orders;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime;
    }
    
    public function __toString()
    {
        return $this->getName();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getActores(): ?string
    {
        return $this->actores;
    }

    public function setActores(?string $actores): self
    {
        $this->actores = $actores;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

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
     * Add reviews
     *
     * @param \App\Entity\Review $reviews
     * @return Movie
     */
    public function addReview(\App\Entity\Review $reviews)
    {
        $this->reviews[] = $reviews;

        return $this;
    }

    /**
     * Remove reviews
     *
     * @param \App\Entity\Review $reviews
     */
    public function removeReview(\App\Entity\Review $reviews)
    {
        $this->reviews->removeElement($reviews);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReviews()
    {
        return $this->reviews;
    }
    
    public function getApprovedReviews()
    {
        $reviews = array();
        foreach ($this->getReviews() as $review) {
            if ($review->getIsModerated()) {
                $reviews[] = $review;
            }
        }
        
        return $reviews;
    }
    
    /**
     * Add categories
     *
     * @param \App\Entity\Category $categories
     * @return Movie
     */
    public function addCategory(\App\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \App\Entity\Category $categories
     */
    public function removeCategory(\App\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add orders
     *
     * @param \App\Entity\Order $orders
     * @return Movie
     */
    public function addOrder(\App\Entity\Order $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \App\Entity\Order $orders
     */
    public function removeOrder(\App\Entity\Order $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }
    
    /**
     * Set nbOrders
     *
     * @param integer $nbOrders
     * @return Movie
     */
    public function setNbOrders($nbOrders)
    {
        $this->nbOrders = $nbOrders;

        return $this;
    }

    /**
     * Get nbOrders
     *
     * @return integer 
     */
    public function getNbOrders()
    {
        return $this->nbOrders;
    }

    /**
     * Set nbReviews
     *
     * @param integer $nbReviews
     * @return Movie
     */
    public function setNbReviews($nbReviews)
    {
        $this->nbReviews = $nbReviews;

        return $this;
    }

    /**
     * Get nbReviews
     *
     * @return integer 
     */
    public function getNbReviews()
    {
        return $this->nbReviews;
    }
}
