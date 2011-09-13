<?php

namespace Custom\PeopleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="photo")
 * @ORM\HasLifecycleCallbacks
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    protected $filename;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="tags")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $person;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

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
    public function setFilename($name)
    {
        $this->filename = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set person
     
     * @param Custom\PeopleBundle\Entity\Person $person
     */
    public function setPerson(\Custom\PeopleBundle\Entity\Person $person)
    {
        $this->person = $person;
    }

    /**
     * Get person
     *
     * @return Custom\PeopleBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Get absolut path
     * 
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->filename ? null : $this->getUploadRootDir().'/'.$this->filename;
    }

    /**
     * Get web path
     * 
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->filename ? null : $this->getUploadDir().'/'.$this->filename;
    }
   
    /**
     * Get upload root directory
     * 
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Get upload directory
     * 
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/people';
    }

    /**
     * Set file
     * 
     * @param $file
     */
    public function setFile($file)
    {
        $this->file = $file;
        if (null !== $this->file) {
            $this->setFilename(uniqid().'.'.$this->file->guessExtension());
        }
    }
    
    /**
     * Get file
     *
     * $return $file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        $this->file->move($this->getUploadRootDir(), $this->filename);

        unset($this->filefile);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($filename = $this->getAbsolutePath()) {
            unlink($filename);
        }
    }
}
