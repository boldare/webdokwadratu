<?php

namespace Custom\AuthorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Author repository
 */
class AuthorRepository extends EntityRepository
{
    /**
     * Get author list in weight order
     *
     * @return Doctrine\Common\Collections\Collection
     */ 
    public function findAll()
    {
        $query = $this->_em->createQuery(
            'SELECT a FROM Custom\AuthorBundle\Entity\Author a ORDER BY a.weight ASC'
        );
        return $query->getResult();
    }
}
