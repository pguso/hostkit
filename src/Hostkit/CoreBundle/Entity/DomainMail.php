<?php


namespace Hostkit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="domain_mail")
 */
class DomainMail
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $domainId;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $alternative;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $language;

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
     * @return DomainMail
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
     * Set d
     *
     * @param string $d
     * @return DomainMail
     */
    public function setD($d)
    {
        $this->d = $d;

        return $this;
    }

    /**
     * Get d
     *
     * @return string 
     */
    public function getD()
    {
        return $this->d;
    }

    /**
     * Set alternative
     *
     * @param string $alternative
     * @return DomainMail
     */
    public function setAlternative($alternative)
    {
        $this->alternative = $alternative;

        return $this;
    }

    /**
     * Get alternative
     *
     * @return string 
     */
    public function getAlternative()
    {
        return $this->alternative;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return DomainMail
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set domainId
     *
     * @param string $domainId
     * @return DomainMail
     */
    public function setDomainId($domainId)
    {
        $this->domainId = $domainId;

        return $this;
    }

    /**
     * Get domainId
     *
     * @return string 
     */
    public function getDomainId()
    {
        return $this->domainId;
    }
}
