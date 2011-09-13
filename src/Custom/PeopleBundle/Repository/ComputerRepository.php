<?php

namespace Custom\PeopleBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Computer repository
 */
class ComputerRepository extends EntityRepository
{
    /**
     * Get computers list in alphabetical order
     *
     * @return Doctrine\Common\Collections\Collection
     */ 
    public function findAll()
    {
        $query = $this->_em->createQuery(
            'SELECT c FROM Custom\PeopleBundle\Entity\Computer c ORDER BY c.name ASC'
        );
        return $query->getResult();
    }
}
