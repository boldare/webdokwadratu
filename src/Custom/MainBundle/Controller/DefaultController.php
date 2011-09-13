<?php

namespace Custom\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Main section controller
 */
class DefaultController extends Controller
{
    /**
     * About page
     */
    public function aboutAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
      	$article = $em->getRepository('ArticleBundle:Article')->findOneBy(array('slug' => 'about'));
        
        return $this->render('MainBundle:Default:about.html.twig', array(
            'article' => $article,
	      ));
    }

    /**
     * Partners page
     */
    public function partnersAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
	      $partners = $em->getRepository('PartnerBundle:Partner')->findAll();
	
        return $this->render('MainBundle:Default:partners.html.twig', array(
	          'partners' => $partners,
	      ));
    }

    /**
     * Authors page
     */
    public function authorsAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
	      $authors = $em->getRepository('AuthorBundle:Author')->findAll();
	
        return $this->render('MainBundle:Default:authors.html.twig', array(
	          'authors' => $authors,
	      ));
    }

    /**
     * Album page
     */ 
    public function albumAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
	      $article = $em->getRepository('ArticleBundle:Article')->findOneBy(array('slug' => 'album'));
	
        return $this->render('MainBundle:Default:album.html.twig', array(
            'article' => $article,
	      ));
    }

    /**
     * Contact page
     */
    public function contactAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
	      $article = $em->getRepository('ArticleBundle:Article')->findOneBy(array('slug' => 'contact'));
	      
        return $this->render('MainBundle:Default:contact.html.twig', array(
            'article' => $article,
	      ));
    }

    /**
     * Administration main page
     */
    public function adminAction()
    {
        return $this->render('MainBundle:Default:admin.html.twig');
    }
}
