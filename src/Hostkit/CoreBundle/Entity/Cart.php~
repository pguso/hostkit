<?php


namespace Hostkit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cart")
 */
class Cart {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", length=155)
     */
    protected $productId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $domain;		
	
	/**     
	* @ORM\Column(type="string", length=255, nullable=true)     
	*/    
	protected $tld;
	
	/**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $domainMode;	
	
	/**     
	* @ORM\Column(type="integer", length=55, nullable=true)     
	*/    
	protected $billing_cycle;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $sessionId;
	
	/**
     * @ORM\Column(type="integer", length=100, nullable=true)
     */
    protected $clientId;

    /**
     * @ORM\Column(type="datetime", length=300)
     */
    protected $createdAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set productId
     *
     * @param integer $productId
     * @return Cart
     */
    public function setProductId($productId) {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer
     */
    public function getProductId() {
        return $this->productId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Cart
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Set sessionId
     *
     * @param string $sessionId
     * @return Cart
     */
    public function setSessionId($sessionId) {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId() {
        return $this->sessionId;
    }

    /**
     * Set createdAt
     *
     * @param string $createdAt
     * @return Cart
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return string
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return Cart
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
     * Set tld
     *
     * @param string $tld
     * @return Cart
     */
    public function setTld($tld)
    {
        $this->tld = $tld;

        return $this;
    }

    /**
     * Get tld
     *
     * @return string 
     */
    public function getTld()
    {
        return $this->tld;
    }

    /**
     * Set billing_cycle
     *
     * @param integer $billingCycle
     * @return Cart
     */
    public function setBillingCycle($billingCycle)
    {
        $this->billing_cycle = $billingCycle;

        return $this;
    }

    /**
     * Get billing_cycle
     *
     * @return integer 
     */
    public function getBillingCycle()
    {
        return $this->billing_cycle;
    }

    /**
     * Set clientId
     *
     * @param integer $clientId
     * @return Cart
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return integer 
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set domainMode
     *
     * @param string $domainMode
     * @return Cart
     */
    public function setDomainMode($domainMode)
    {
        $this->domainMode = $domainMode;

        return $this;
    }

    /**
     * Get domainMode
     *
     * @return string 
     */
    public function getDomainMode()
    {
        return $this->domainMode;
    }
}
