<?php

namespace Custom\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Custom\PeopleBundle\Form\SearchType;

/**
 * Default people controler. Frontend for person related pages
 */
class DefaultController extends Controller
{
    /**
     * Lists persons entities.
     */
    public function peopleAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $people = $em->getRepository('PeopleBundle:Person')->findAll();
        $industries = $em->getRepository('PeopleBundle:Industry')->findAll();
        $computers = $em->getRepository('PeopleBundle:Computer')->findAll();

        return $this->render('PeopleBundle:Default:people.html.twig', array(
            'people' => $people,
            'industries' => $industries,
            'computers' => $computers,
        ));
    }

    /**
     * Display alphabet (based on initials)
     */
    public function alphabetAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $initials = $em->getRepository('PeopleBundle:Person')->getInitals();

        return $this->render('PeopleBundle:Default:alphabet.html.twig', array(
            'alphabet' => $initials
        ));
    }

    /**
     * Display initials ranges
     */
    public function rangesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $initials = $em->getRepository('PeopleBundle:Person')->getInitals();

        return $this->render('PeopleBundle:Default:ranges.html.twig', array(
            'alphabet' => $initials
        ));
    }

    /**
     * Display person list with given initial
     */
    public function initialAction($letter)
    {
        // fixme: deployment hotfix
        if (strlen($letter) > 2)
        {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PeopleBundle:Person')->findBy(array('initial' => $letter));

        return $this->render('PeopleBundle:Default:initial.html.twig', array(
            'people' => $entities,
            'header' => $letter,
        ));
    }

    /**
     * Display person list in range from - to
     */
    public function rangeAction($from, $to)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PeopleBundle:Person')->getByInitials($from, $to);

        return $this->render('PeopleBundle:Default:initial.html.twig', array(
            'people' => $entities,
            'header' => sprintf('%s - %s', $from, $to),
        ));
        
    }

    /**
     * Show person
     */
    public function personAction($id, $color = null)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $person = $em->getRepository('PeopleBundle:Person')->findOneBy(array('id' => $id));
        $people = $em->getRepository('PeopleBundle:Person')->getAdditional($person);

        return $this->render('PeopleBundle:Default:person.html.twig', array(
            'person' => $person,
            'people' => $people,
            'color' => $color,
        ));
    }

    /**
     * Show person based on name
     */
    public function personNameAction($firstname, $lastname, $color = null)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $person = $em->getRepository('PeopleBundle:Person')->findOneBy(array(
            'first_name' => $firstname,
            'last_name' => $lastname,
        ));

        // fixme: hotfix
        if (!$person) {
            throw $this->createNotFoundException();
        }

        $people = $em->getRepository('PeopleBundle:Person')->getAdditional($person);

        return $this->render('PeopleBundle:Default:person.html.twig', array(
            'person' => $person,
            'people' => $people,
            'color' => $color,
        ));
    }

    /**
     * Display people list as a slider
     */
    public function sliderAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $people = $em->getRepository('PeopleBundle:Person')->findAll();
        return $this->render('PeopleBundle:Default:slider.html.twig', array(
            'people' => $people,
        ));
    }

    /**
     * Display searchbox
     */
    public function searchboxAction()
    {
        $form = $this->createForm(new SearchType());
        
        return $this->render('PeopleBundle:Default:searchbox.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Simple search for people
     */
    public function searchAction()
    {
        $parameters = $this->getRequest()->request->get('custom_peoplebundle_searchtype');
        if (!isset($parameters['keyword']) || empty($parameters['keyword']))
        {
            return $this->redirect($this->generateUrl('PeopleBundlePeople'));
        }

        $keyword = $parameters['keyword'];
        $em = $this->getDoctrine()->getEntityManager();
        $people = $em->getRepository('PeopleBundle:Person')->search($keyword);
        

        return $this->render('PeopleBundle:Default:search.html.twig', array(
            'people' => $people,
            'header' => 'Search',
        ));
    }
}
