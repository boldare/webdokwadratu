<?php

namespace Custom\PeopleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Custom\PeopleBundle\Repository\PersonRepository")
 * @ORM\Table(name="person")
 */
class Person
{
    const SUMMARY_LIMIT = 400;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $last_name;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    protected $twitter;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    protected $facebook;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    protected $linkedin;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    protected $website;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    protected $email;

    /**
     * @ORM\ManyToOne(targetEntity="Computer", inversedBy="people")
     * @ORM\JoinColumn(name="first_computer_id", referencedColumnName="id")
     */
    protected $first_computer;

    /**
     * @ORM\ManyToOne(targetEntity="Industry", inversedBy="people")
     * @ORM\JoinColumn(name="industry_id", referencedColumnName="id")
     */
    protected $industry;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     */
    protected $quotation;

    /**
     * @ORM\Column(type="string", length=1)
     */
    protected $initial;
  
    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="person", cascade={"all"})
     */
    protected $photos;

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="person", cascade={"all"})
     */
    protected $tags;

    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set first_name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
        $initial = strtolower($this->last_name[0]);
        $this->setInitial($initial);
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
    }

    /**
     * Get linkedin
     *
     * @return string 
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set website
     *
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get summary
     */
    public function getSummary()
    {
        $suffix = mb_strlen($this->description, 'utf-8') > self::SUMMARY_LIMIT ? '...' : '';
        return mb_strcut($this->description, 0, self::SUMMARY_LIMIT, 'UTF-8') . $suffix;
    }

    /**
     * Set quotation
     *
     * @param text $quotation
     */
    public function setQuotation($quotation)
    {
        $this->quotation = $quotation;
    }

    /**
     * Get quotation
     *
     * @return text 
     */
    public function getQuotation()
    {
        return $this->quotation;
    }

    /**
     * Set initial
     *
     * @param string $initial
     */
    public function setInitial($initial)
    {
        $this->initial = $initial;
    }

    /**
     * Get initial
     *
     * @return string 
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * Set first_computer
     *
     * @param Custom\PeopleBundle\Entity\Computer $firstComputer
     */
    public function setFirstComputer(\Custom\PeopleBundle\Entity\Computer $firstComputer)
    {
        $this->first_computer = $firstComputer;
    }

    /**
     * Get first_computer
     *
     * @return Custom\PeopleBundle\Entity\Computer 
     */
    public function getFirstComputer()
    {
        return $this->first_computer;
    }

    /**
     * Set industry
     *
     * @param Custom\PeopleBundle\Entity\Industry $industry
     */
    public function setIndustry(\Custom\PeopleBundle\Entity\Industry $industry)
    {
        $this->industry = $industry;
    }

    /**
     * Get industry
     *
     * @return Custom\PeopleBundle\Entity\Industry 
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Add photos
     *
     * @param Custom\PeopleBundle\Entity\Photo $photos
     */
    public function addPhotos(\Custom\PeopleBundle\Entity\Photo $photos)
    {
        $photos->setPerson($this);
        $this->photos[] = $photos;
    }

    /**
     * Get photos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Get main photo (first one)
     */
    public function getMainPhoto()
    {
        return $this->photos->first();
    }

    /**
     * Get large photo (second one)
     */
    public function getLargePhoto()
    {
        return $this->photos[1];
    }

    /**
     * Add tags
     *
     * @param Custom\PeopleBundle\Entity\Tag $tags
     */
    public function addTags(\Custom\PeopleBundle\Entity\Tag $tags)
    {
        $tags->setPerson($this);
        $this->tags[] = $tags;
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Returns false if object has been persisted 
     * TODO Use em to check
     *
     * @return boolean
     */
    public function isNew()
    {
        return is_null($this->id);
    }
}
