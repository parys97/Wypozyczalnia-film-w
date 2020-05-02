<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/list", name="category_list")
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()->getRepository(\App\Entity\Category::class)
            ->findAll();
    
        return $this->render('category/list.html.twig', [
            'categories'    => $categories
        ]);
    }
    
    /**
     * @Route("/{id}", name="category_show")
     */
    public function showAction($id)
    {
        $category = $this->getDoctrine()->getRepository(\App\Entity\Category::class)
            ->find($id);
        
        if (!$category) {
            throw $this->createNotFoundException("Kayegoria nie została odnaleziona.");
        }
        
        $movies = $this->getDoctrine()
            ->getRepository(\App\Entity\Movie::class)
            ->createQueryBuilder('m')
            ->innerJoin('m.categories', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $category->getId())
            ->getQuery()
            ->getResult();
        
        return $this->render('category/show.html.twig', [
            'category'  => $category,
            'movies'    => $movies
        ]);
    }
}
