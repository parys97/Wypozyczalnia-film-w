<?php
namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user")
     */
    protected $orders;
    
    /**
     * @var ArrayCollection
     * 
     * * @ORM\OneToMany(targetEntity="Review", mappedBy="user")
     */
    protected $reviews;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    public function getOrderedMovies()
    {
        $movies = array();
        foreach ($this->getOrders() as $order) {
            foreach ($order->getMovies() as $movie) {
                // pomiń jeśli zamówienie nie jest opłacone
                if (!$order->isPaid()) {
                    continue;
                }
                
                // opłacone filmy
                if (!array_key_exists($movie->getId(), $movies)) {
                    $movies[$movie->getId()] = $movie;
                }
            }
        }
        
        return $movies;
    }
    
    public function isOrderedMovie(Movie $movie)
    {
        $movies = $this->getOrderedMovies();
        
        return array_key_exists($movie->getId(), $movies);
    }

    /**
     * Add orders
     *
     * @param \App\Entity\Order $orders
     * @return User
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
     * Add reviews
     *
     * @param \App\Entity\Review $reviews
     * @return User
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
}