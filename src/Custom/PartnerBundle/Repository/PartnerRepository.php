<?php

namespace Custom\PartnerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Partner repository
 */
class PartnerRepository extends EntityRepository
{
    /**
     * Get partners list in weight order
     *
     * @return Doctrine\Common\Collections\Collection
     */ 
    public function findAll()
    {
        $query = $this->_em->createQuery(
            'SELECT p FROM Custom\PartnerBundle\Entity\Partner p ORDER BY p.weight ASC'
        );
        return $query->getResult();
    }
}
