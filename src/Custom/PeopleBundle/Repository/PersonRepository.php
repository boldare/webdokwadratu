<?php

namespace Custom\PeopleBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Person repository
 */
class PersonRepository extends EntityRepository
{
    /**
     * Get people list in reverse order (newest first)
     *
     * @return Doctrine\Common\Collections\Collection
     */ 
    public function findAll()
    {
        $query = $this->_em->createQuery(
            'SELECT p FROM Custom\PeopleBundle\Entity\Person p ORDER BY p.id DESC'
        );
        return $query->getResult();
    }

    /**
     * Get available initials
     *
     * @return array
     */
    public function getInitals()
    {
        $query = $this->_em->createQuery(
            'SELECT DISTINCT(p.initial) AS initial FROM Custom\PeopleBundle\Entity\Person p ORDER BY p.initial ASC'
        );
        $results = $query->getResult();
        $initials = array();

        foreach ($results as $result)
        {
            $initials[] = strtolower($result['initial']);
        }
        return $initials;
    }

    /**
     * Finds 4 random person but not given one
     *
     * @param \Custom\PeopleBundle\Entity\Person 
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAdditional(\Custom\PeopleBundle\Entity\Person $person)
    {
	    $rsm = new \Doctrine\ORM\Query\ResultSetMapping;
	    $rsm->addEntityResult('Custom\PeopleBundle\Entity\Person', 'p');
	    $rsm->addFieldResult('p', 'id', 'id');
	    $rsm->addFieldResult('p', 'first_name', 'first_name');
	    $rsm->addFieldResult('p', 'last_name', 'last_name');
	    $query = $this->_em->createNativeQuery('SELECT id, first_name, last_name, RAND() as rand FROM person WHERE person.id != ? ORDER BY rand LIMIT 4', $rsm);
	    $query->setParameter(1, $person->getId());

	    return $query->getResult();
    }

    /**
     * Finds people in ranges from - to
     *
     * @param from string (single char)
     * @param to string (single char)
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getByInitials($from, $to)
    {
        $initials = $this->getAlphabetFromRange($from, $to);
        $query = $this->_em->createQuery(
            'SELECT p FROM Custom\PeopleBundle\Entity\Person p WHERE p.initial in (:initials)'
        );
        $query->setParameter('initials', $initials);

        return $query->getResult();
    }

    /**
     * Returns alphabet slice by range 
     * E.g. getAlphabetFromRange('a', 'c') returns array('a', 'b', 'c')
     * 
     * @return array
     */
    protected function getAlphabetFromRange($letter1, $letter2)
    {
        $character1 = ord($letter1);
        $character2 = ord($letter2);

        if ($character1 < $character2)
        {
            $from = $character1;
            $to = $character2;
        }
        else
        {
            $from = $character2;
            $to = $character1;
        }

        $range = range($from, $to);
        $result = array_map('chr', $range);
        return $result;
    }

    /**
     * Simple search person
     * Search by: first name, last name, description, first computer, tags, industry
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function search($keyword)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->add('select', 'p')
                     ->add('from', 'Custom\PeopleBundle\Entity\Person p')
                     ->orWhere($queryBuilder->expr()->like('p.first_name', '?1'))
                     ->orWhere($queryBuilder->expr()->like('p.last_name', '?1'))
                     ->orWhere($queryBuilder->expr()->like('p.description', '?1'))
                     ->innerJoin('p.first_computer', 'c')
                     ->orWhere($queryBuilder->expr()->like('c.name', '?1'))
                     ->innerJoin('p.tags', 't')
                     ->orWhere($queryBuilder->expr()->like('t.name', '?1'))
                     ->innerJoin('p.industry', 'i')
                     ->orWhere($queryBuilder->expr()->like('i.name', '?1'))
                     ->setParameter(1, '%'.$keyword.'%');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
}
