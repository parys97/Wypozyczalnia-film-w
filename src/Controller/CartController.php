<?php
namespace App\Controller;

use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart")
     */
    public function listAction(Cart $cart)
    {
        return $this->render('cart/list.html.twig', [
            'cart'  => $cart
        ]);
    }
    
    /**
     * @Route("/{id}/remove", name="cart_remove")
     */
    public function cartAction($id, Cart $cart)
    {
        $movie = $this->getDoctrine()->getRepository(\App\Entity\Movie::class)
            ->find($id);
        
        if (!$movie) {
            throw $this->createNotFoundException("Film nie został odnaleziony.");
        }
        
        $cart->remove($movie);
        
        $this->addFlash('notice', 'Film został pomyślnie usunięty z koszyka.');
        
        return $this->redirectToRoute('cart');
    }
}
