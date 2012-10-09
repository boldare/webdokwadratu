<?php

namespace Custom\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Frontend controller for news section
 */
class DefaultController extends Controller
{
    /**
     * Display news list with pager
     */
    public function indexAction()
    {
        $page = $this->get('request')->query->get('page', 1);
        $paginator = $this->get('custom.newsbundle.repository.news')->getLastNewsPaginator($page);

        return $this->render('NewsBundle:Default:index.html.twig', array(
            'paginator' => $paginator,
        ));
    }

    /**
     * Display single news
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('NewsBundle:News');

        $entity = $repository->findOneBy(array('id' => $id));

        // fixme: hotfix
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $next = $repository->getNext($entity);
        $previous = $repository->getPrevious($entity);


        return $this->render('NewsBundle:Default:show.html.twig', array(
            'entity' => $entity,
            'next' => $next,
            'previous' => $previous,
        ));
    }
}
