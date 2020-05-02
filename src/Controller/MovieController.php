<?php
namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Order;
use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    
    /**
     * @IsGranted("ROLE_USER")
     *
     * @Route("/order", name="movie_order")
     */
    public function orderAction(Cart $cart, \Swift_Mailer $mailer)
    {
        $movies = $cart->getMovies();
        if (count($movies) < 1) {
            // film jest już w koszyku
            $this->addFlash('error', "Nie możesz złożyć zamówienia - koszyk jest pusty.");
        }
    
        $user = $this->getUser();
    
        $order = new Order();
        $order->setUser($user);
        foreach ($movies as $movie) {
            $order->addMovie($movie);
            
            // aktualizuj liczbę zamówień dla filmu
            $movie->setNbOrders($movie->getNbOrders() + 1);
        }
    
        $em = $this->getDoctrine()->getManager();
    
        $em->persist($order);
        $em->flush();
    
        // wyczyść koszyk
        $cart->clear();
    
        // wyślij miala ze szczegółami płatności
        $message = $mailer->createMessage()
            ->setSubject('MovieShop.pl - potwierdzenie zamówienia')
            ->setFrom('no-reply@movieshop.pl')
            ->setTo($user->getEmail())
            ->setBody($this->renderView(
                'movie/emailConfirmation.html.twig',
                array('user' => $user)
        ),'text/html');
        
        $mailer->send($message);
        
        $this->addFlash('notice', "Zamówienie zostało zapisane. Na podany adres e-mail zostały wysłane informacje na temat płatności.");
    
        return $this->redirectToRoute('order_confirm', array('id' => $order->getId()));
    }
    
    /**
     * @Route("/{id}", name="movie_show")
     */
    public function showAction($id)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)
            ->find($id);
        
        if (!$movie) {
            throw $this->createNotFoundException("Film nie został odnaleziony.");
        }
        
        return $this->render('movie/show.html.twig', [
            'movie' => $movie
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * 
     * @Route("/{id}/rent", name="movie_rent")
     */
    public function rentAction($id, Request $request, Cart $cart)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)
            ->find($id);
        
        if (!$movie) {
            throw $this->createNotFoundException("Film nie został odnaleziony.");
        }
        
        if ($cart->has($movie)) {
            // film jest już w koszyku
            $this->addFlash('error', "Ten film znajduje się już w Twoim koszyku.");
        } else {
            $cart->add($movie);
            $this->addFlash('notice', "Film został pomyślnie dodany do koszyka.");
        }
        
        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * @Route("/{id}/watch", name="movie_watch")
     */
    public function watchAction($id, Request $request)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)
            ->find($id);

        if (!$movie) {
            throw $this->createNotFoundException("Film nie został odnaleziony.");
        }
        
        if (!$this->getUser()->isOrderedMovie($movie)) {
            $this->addFlash('error', 'Ten film nie został jeszcze opłacony!');
            return $this->redirectToRoute('homepage');
        }
        
        $this->addFlash('notice', "Odtwarzanie filmu");
    
        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * @IsGranted("ROLE_USER")
     * 
     * @Route("/{id}/add-review", name="movie_add_review")
     */
    public function addReviewAction($id, Request $request)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)
            ->find($id);
        
        if (!$movie) {
            throw $this->createNotFoundException("Film nie został odnaleziony.");
        }
        
        $review = new \App\Entity\Review();
        $review->setMovie($movie);
        $review->setUser($this->getUser());
        
        $form = $this->createForm(\App\Form\ReviewType::class, $review);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            
            // zwiększa liczbę opinie
            $movie->setNbReviews($movie->getNbReviews() + 1);
            
            $em->flush();
            
            $this->addFlash('notice', "Recenzja została pomyślnie dodana i oczekuje na moderację.");
            return $this->redirectToRoute('movie_show', array('id' => $movie->getId()));
        }
        
        return $this->render('movie/addReview.html.twig', [
            'movie' => $movie,
            'form'  => $form->createView()
        ]);
    }
}
