<?php

namespace Custom\PeopleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Custom\PeopleBundle\Repository\ComputerRepository")
 * @ORM\Table(name="computer")
 */
class Computer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Person", mappedBy="first_computer")
     */
    protected $people;

    public function __construct()
    {
        $this->people = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add people
     *
     * @param Custom\PeopleBundle\Entity\Person $people
     */
    public function addPeople(\Custom\PeopleBundle\Entity\Person $people)
    {
        $this->people[] = $people;
    }

    /**
     * Get people
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * toString
     *
     * $return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
