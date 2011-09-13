<?php

namespace Custom\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;

/**
 * News repository
 */
class NewsRepository extends EntityRepository
{
    const ITEMS_COUNT_PER_PAGE = 3;

    private $container;

    /**
     * Returns pager of news entities
     *
     * @param integer $page
     * @return Zend\Paginator\Paginator
     */
    public function getLastNewsPaginator($page = 1)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT n FROM NewsBundle:News n ORDER BY n.created_at DESC";
        $query = $em->createQuery($dql);

        $adapter = $this->container->get('knp_paginator.adapter');
        $adapter->setQuery($query);
        $adapter->setDistinct(true);
        
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber((int)$page);
        $paginator->setItemCountPerPage(self::ITEMS_COUNT_PER_PAGE);
        $paginator->setPageRange(5);
        return $paginator;
    }

    /**
     * Set DIC in service manger
     *
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function setContainer(\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get previous news based on created_at column 
     *
     * @param \Custom\NewsBundle\Entity\News $news
     * @return \Custom\NewsBundle\Entity\News
     */
    public function getPrevious(\Custom\NewsBundle\Entity\News $news)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT n FROM NewsBundle:News n WHERE n.created_at <= ?1 AND n.id != ?2 ORDER BY n.created_at DESC";
        $query = $em->createQuery($dql);
        $query->setParameters(array(1 => $news->getCreatedAt(), 2 => $news->getId()));
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }

    /**
     * Get next news based on created_at column
     *
     * @param \Custom\NewsBundle\Entity\News $news
     * @return \Custom\NewsBundle\Entity\News
     */
    public function getNext(\Custom\NewsBundle\Entity\News $news)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT n FROM NewsBundle:News n WHERE n.created_at >= ?1 AND n.id != ?2 ORDER BY n.created_at ASC";
        $query = $em->createQuery($dql);
        $query->setParameters(array(1 => $news->getCreatedAt(), 2 => $news->getId()));
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }
}
