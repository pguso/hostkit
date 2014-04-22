<?php


namespace Hostkit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="api_user")
 */
class ApiUser
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
    protected $user_id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $server_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $cost;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $max_user;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $ip_address;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $username;
    
    /**
     * @ORM\Column(type="string", length=300)
     */
    protected $password;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $debug_modus;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $domain;
    
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $ssl;
    

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
     * Set ip_address
     *
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ip_address = $ipAddress;
    }

    /**
     * Get ip_address
     *
     * @return string 
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $password = md5($password);
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set debug_modus
     *
     * @param string $debugModus
     */
    public function setDebugModus($debugModus)
    {
        $this->debug_modus = $debugModus;
    }

    /**
     * Get debug_modus
     *
     * @return string 
     */
    public function getDebugModus()
    {
        return $this->debug_modus;
    }

    /**
     * Set user_id
     *
     * @param string $userId
     * @return ApiUser
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    
        return $this;
    }

    /**
     * Get user_id
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return ApiUser
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    
        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set ssl
     *
     * @param integer $ssl
     * @return ApiUser
     */
    public function setSsl($ssl)
    {
        if($ssl == true) {
            $ssl = 1;
        } else if($ssl == false) {
            $ssl = 2;
        } //var_dump($ssl);die();
        $this->ssl = $ssl;
    
        return $this;
    }

    /**
     * Get ssl
     *
     * @return integer 
     */
    public function getSsl()
    {
        if($this->ssl == 1) {
            $this->ssl = true;
        } else if($this->ssl == 0) {
            $this->ssl = false;
        }
        return $this->ssl;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ApiUser
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
     * Set cost
     *
     * @param string $cost
     * @return ApiUser
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    
        return $this;
    }

    /**
     * Get cost
     *
     * @return string 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set max_user
     *
     * @param string $maxUser
     * @return ApiUser
     */
    public function setMaxUser($maxUser)
    {
        $this->max_user = $maxUser;
    
        return $this;
    }

    /**
     * Get max_user
     *
     * @return string 
     */
    public function getMaxUser()
    {
        return $this->max_user;
    }

    /**
     * Set server_name
     *
     * @param string $serverName
     * @return ApiUser
     */
    public function setServerName($serverName)
    {
        $this->server_name = $serverName;
    
        return $this;
    }

    /**
     * Get server_name
     *
     * @return string 
     */
    public function getServerName()
    {
        return $this->server_name;
    }

    /**
     * Set secure
     *
     * @param integer $secure
     * @return ApiUser
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;
    
        return $this;
    }

    /**
     * Get secure
     *
     * @return integer 
     */
    public function getSecure()
    {
        return $this->secure;
    }
}
