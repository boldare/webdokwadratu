<?php

namespace Custom\PeopleBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Industry repository
 */
class IndustryRepository extends EntityRepository
{
    /**
     * Get industries list in alphabetical order
     *
     * @return Doctrine\Common\Collections\Collection
     */ 
    public function findAll()
    {
        $query = $this->_em->createQuery(
            'SELECT i FROM Custom\PeopleBundle\Entity\Industry i ORDER BY i.name ASC'
        );
        return $query->getResult();
    }
}
