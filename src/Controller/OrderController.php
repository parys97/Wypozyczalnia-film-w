<?php
namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * 
     * @Route("/list", name="order_list")
     */
    public function listAction()
    {
        $orders = $this->getDoctrine()->getRepository(Order::class)
            ->findBy(array('user' => $this->getUser()));
        
        return $this->render('order/list.html.twig', [
            'orders'    => $orders
        ]);
    }
    
    /**
     * @IsGranted("ROLE_USER")
     *
     * @Route("/movies", name="order_movies")
     */
    public function moviesAction()
    {
        // zamówione filmy
        $movies = $this->getUser()->getOrderedMovies(); 
    
        return $this->render('order/movies.html.twig', [
            'movies'    => $movies
        ]);
    }
    
    /**
     * @IsGranted("ROLE_USER")
     *
     * @Route("/{id}/show", name="order_show")
     */
    public function showAction($id)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)
            ->find($id);
        
        if (!$order) {
            throw $this->createNotFoundException("Nie znaleziono zamówienia");
        }
    
        return $this->render('order/show.html.twig', [
            'order'    => $order
        ]);
    }
    
    /**
     * @IsGranted("ROLE_USER")
     *
     * @Route("/{id}/confirmation", name="order_confirm")
     */
    public function confirmAction($id)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)
            ->find($id);
    
        if (!$order) {
            throw $this->createNotFoundException("Nie znaleziono zamówienia");
        }
    
        return $this->render('order/confirm.html.twig', [
            'order'    => $order
        ]);
    }
}
