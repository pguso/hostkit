<?php


namespace Hostkit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email")
 */
class Email
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $subject;
	
	/**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $type;
	
	/**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    protected $contentTop;
	
	/**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    protected $contentInner;
	

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
     * @return Email
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set type
     *
     * @param string $type
     * @return Email
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set contentTop
     *
     * @param string $contentTop
     * @return Email
     */
    public function setContentTop($contentTop)
    {
        $this->contentTop = $contentTop;

        return $this;
    }

    /**
     * Get contentTop
     *
     * @return string 
     */
    public function getContentTop()
    {
        return $this->contentTop;
    }

    /**
     * Set contentInner
     *
     * @param string $contentInner
     * @return Email
     */
    public function setContentInner($contentInner)
    {
        $this->contentInner = $contentInner;

        return $this;
    }

    /**
     * Get contentInner
     *
     * @return string 
     */
    public function getContentInner()
    {
        return $this->contentInner;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Email
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
