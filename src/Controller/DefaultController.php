<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        // lista wszystkich filmów
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();
        
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        
        // lista popularnych filmów
        $popular = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findBy(array(), array('nbOrders' => 'desc'), 5);
        
        // lista najczęściej recenzowanych filmów
        $frequentlyReviewed = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findBy(array(), array('nbReviews' => 'desc'), 5);
        
        return $this->render('default/index.html.twig', [
            'movies'                => $movies,
            'categories'            => $categories,
            'popular'               => $popular,
            'frequentlyReviewed'    => $frequentlyReviewed
        ]);
    }
    
    /**
     * @Route("/popular", name="popular")
     */
    public function poopular()
    {
        // lista popularnych filmów
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findBy(array(), array('nbOrders' => 'desc'));
    
        return $this->render('default/movies.html.twig', [
            'title'     => "Lista popularnych filmów",
            'movies'    => $movies
        ]);
    }
    
    /**
     * @Route("/mostly-reviewed", name="reviewed")
     */
    public function reviewed()
    {
        // lista najczęściej recenzowanych filmów
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findBy(array(), array('nbReviews' => 'desc'));
    
        return $this->render('default/movies.html.twig', [
            'title'     => "Lista najczęściej recenzowanych filmów",
            'movies'    => $movies
        ]);
    }
    
    /**
     * @Route("/seach", name="search")
     */
    public function search(Request $request)
    {
        if (!$query = $request->query->get('q', false)) {
            return $this->redirectToRoute('homepage');
        }
        
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->createQueryBuilder('m')
            ->innerJoin('m.categories', 'c')
            ->where('m.name LIKE :name OR m.description LIKE :description OR m.actores LIKE :actores')
            ->setParameters(array(
                'name'  => "%".$query."%",
                'description'  => "%".$query."%",
                'actores'  => "%".$query."%",
            ))
            ->getQuery()
            ->getResult();
            
        return $this->render('default/search.html.twig', [
            'movies'    => $movies
        ]);
    }
}
