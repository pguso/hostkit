<?php

namespace Hostkit\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
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
    protected $register_date;

	/**
	 *
	 */
	public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get register_date
     *
     * @return string 
     */
    public function getRegisterDate()
    {
        return $this->register_date;
    }

	/**
	 * Set price
	 *
	 * @param $register_date
	 *
	 * @internal param \Hostkit\UserBundle\Entity\decimal $price
	 */
    public function setRegisterDate($register_date)
    {
        $this->register_date = $register_date;
    }
    
    /**
     * Returns the user roles
     *
     * @return array The roles
     */
    public function getRoles()
    {
        $roles = $this->roles;

        foreach ($this->getGroups() as $group) {
            $roles = array_merge($roles, $group->getRoles());
        }

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }
    
    
    
}