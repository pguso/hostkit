<?php
namespace Hostkit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Hostkit\CoreBundle\Entity\Category;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $catId;
    
    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $typeId;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $price;
	
	/**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $setup;

    /**
     * @ORM\Column(type="string", length=330)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $payment;
    
    /**
     * @ORM\Column(type="integer", length=10)
     */
    protected $quantity;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $uuid;
    
    /**
     * @ORM\Column(type="integer", length=1, nullable=true)
     */
    protected $featured;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $options;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $slug;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $type;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $assets;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $updateAt;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $period;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $term_length;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    protected $price_per_period;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    protected $discount;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    protected $total;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $monthly;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $quarterly;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $semiannual;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $annual;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $msetup;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $qsetup;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $ssetup;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $asetup;
	
	/**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $mdiscount;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $qdiscount;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $sdiscount;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $adiscount;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $cpanel_package;
    

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
     * Set price
     *
     * @param decimal $price
     */
    public function setPrice($price)
    {        
        if(preg_match('#,#', $price)) {
            $price = str_replace(",", ".", $price);
            $this->price = $price;
        } else {
            $this->price = $price;
        }
    }

    /**
     * Get price
     *
     * @return decimal 
     */
    public function getPrice()
    {
        return $this->price;
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
     * Get short description
     *
     * @return text 
     */
    public function getShortDescription()
    {
        $short_description = substr($this->description, 0, 14) . '...';
        return $short_description;
    }
    
    /**
     * Get featured description
     *
     * @return text 
     */
    public function getFeaturedDescription()
    {
        $featured_description = substr($this->description, 0, 70) . '...';
        return $featured_description;
    }

    /**
     * Set cat_id
     *
     * @param integer $catId
     */
    public function setCatId($catId)
    {
        $this->catId = $catId;
    }

    /**
     * Get cat_id
     *
     * @return integer 
     */
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set last_update
     *
     * @param datetime $lastUpdate
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->last_update = $lastUpdate;
    }

    /**
     * Get last_update
     *
     * @return datetime 
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }
    

    /**
     * Set uuid
     *
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set featured
     *
     * @param integer $featured
     */
    public function setFeatured($featured)
    {
        if($featured == true) {
            $this->featured = 1;
        } elseif($featured == false) {
            $this->featured = 0;
        }
        
    }

    /**
     * Get featured
     *
     * @return integer 
     */
    public function getFeatured()
    {
        if($this->featured == 1) {
            return true;
        } elseif($this->featured == 0) {
            return false;
        }
    }

    /**
     * Set createdAt
     *
     * @param string $createdAt
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return string 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set options
     *
     * @param string $options
     * @return Product
     */
    public function setOptions($options)
    {
        $this->options = $options;
    
        return $this;
    }

    /**
     * Get options
     *
     * @return string 
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Product
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
     * Set assets
     *
     * @param string $assets
     * @return Product
     */
    public function setAssets($assets)
    {
        $this->assets = $assets;
    
        return $this;
    }

    /**
     * Get assets
     *
     * @return string 
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Set updateAt
     *
     * @param string $updateAt
     * @return Product
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
    
        return $this;
    }

    /**
     * Get updateAt
     *
     * @return string 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     * @return Product
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    
        return $this;
    }

    /**
     * Get typeId
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set monthly
     *
     * @param string $monthly
     * @return ProductSubscription
     */
    public function setMonthly($monthly)
    {
        $this->monthly = $monthly;

        return $this;
    }

    /**
     * Get monthly
     *
     * @return string
     */
    public function getMonthly()
    {
        return $this->monthly;
    }

    /**
     * Set quarterly
     *
     * @param string $quarterly
     * @return ProductSubscription
     */
    public function setQuarterly($quarterly)
    {
        $this->quarterly = $quarterly;

        return $this;
    }

    /**
     * Get quarterly
     *
     * @return string
     */
    public function getQuarterly()
    {
        return $this->quarterly;
    }

    /**
     * Set semiannual
     *
     * @param string $semiannual
     * @return ProductSubscription
     */
    public function setSemiannual($semiannual)
    {
        $this->semiannual = $semiannual;

        return $this;
    }

    /**
     * Get semiannual
     *
     * @return string
     */
    public function getSemiannual()
    {
        return $this->semiannual;
    }

    /**
     * Set annual
     *
     * @param string $annual
     * @return ProductSubscription
     */
    public function setAnnual($annual)
    {
        $this->annual = $annual;

        return $this;
    }

    /**
     * Get annual
     *
     * @return string
     */
    public function getAnnual()
    {
        return $this->annual;
    }

    /**
     * Set msetup
     *
     * @param string $msetup
     * @return ProductSubscription
     */
    public function setMsetup($msetup)
    {
        $this->msetup = $msetup;

        return $this;
    }

    /**
     * Get msetup
     *
     * @return string
     */
    public function getMsetup()
    {
        return $this->msetup;
    }

    /**
     * Set qsetup
     *
     * @param string $qsetup
     * @return ProductSubscription
     */
    public function setQsetup($qsetup)
    {
        $this->qsetup = $qsetup;

        return $this;
    }

    /**
     * Get qsetup
     *
     * @return string
     */
    public function getQsetup()
    {
        return $this->qsetup;
    }

    /**
     * Set ssetup
     *
     * @param string $ssetup
     * @return ProductSubscription
     */
    public function setSsetup($ssetup)
    {
        $this->ssetup = $ssetup;

        return $this;
    }

    /**
     * Get ssetup
     *
     * @return string
     */
    public function getSsetup()
    {
        return $this->ssetup;
    }

    /**
     * Set asetup
     *
     * @param string $asetup
     * @return ProductSubscription
     */
    public function setAsetup($asetup)
    {
        $this->asetup = $asetup;

        return $this;
    }

    /**
     * Get asetup
     *
     * @return string
     */
    public function getAsetup()
    {
        return $this->asetup;
    }

    /**
     * Set payment
     *
     * @param string $payment
     * @return Product
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    
        return $this;
    }

    /**
     * Get payment
     *
     * @return string 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set period
     *
     * @param integer $period
     * @return Product
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    
        return $this;
    }

    /**
     * Get period
     *
     * @return integer 
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set term_length
     *
     * @param integer $termLength
     * @return Product
     */
    public function setTermLength($termLength)
    {
        $this->term_length = $termLength;
    
        return $this;
    }

    /**
     * Get term_length
     *
     * @return integer 
     */
    public function getTermLength()
    {
        return $this->term_length;
    }

    /**
     * Set price_per_period
     *
     * @param string $pricePerPeriod
     * @return Product
     */
    public function setPricePerPeriod($pricePerPeriod)
    {
        $this->price_per_period = $pricePerPeriod;
    
        return $this;
    }

    /**
     * Get price_per_period
     *
     * @return string 
     */
    public function getPricePerPeriod()
    {
        return $this->price_per_period;
    }

    /**
     * Set discount
     *
     * @param string $discount
     * @return Product
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    
        return $this;
    }

    /**
     * Get discount
     *
     * @return string 
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return Product
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return string 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set setup
     *
     * @param string $setup
     * @return Product
     */
    public function setSetup($setup)
    {
        $this->setup = $setup;

        return $this;
    }

    /**
     * Get setup
     *
     * @return string 
     */
    public function getSetup()
    {
        return $this->setup;
    }

    /**
     * Set mdiscount
     *
     * @param string $mdiscount
     * @return Product
     */
    public function setMdiscount($mdiscount)
    {
        $this->mdiscount = $mdiscount;

        return $this;
    }

    /**
     * Get mdiscount
     *
     * @return string 
     */
    public function getMdiscount()
    {
        return $this->mdiscount;
    }

    /**
     * Set qdiscount
     *
     * @param string $qdiscount
     * @return Product
     */
    public function setQdiscount($qdiscount)
    {
        $this->qdiscount = $qdiscount;

        return $this;
    }

    /**
     * Get qdiscount
     *
     * @return string 
     */
    public function getQdiscount()
    {
        return $this->qdiscount;
    }

    /**
     * Set sdiscount
     *
     * @param string $sdiscount
     * @return Product
     */
    public function setSdiscount($sdiscount)
    {
        $this->sdiscount = $sdiscount;

        return $this;
    }

    /**
     * Get sdiscount
     *
     * @return string 
     */
    public function getSdiscount()
    {
        return $this->sdiscount;
    }

    /**
     * Set adiscount
     *
     * @param string $adiscount
     * @return Product
     */
    public function setAdiscount($adiscount)
    {
        $this->adiscount = $adiscount;

        return $this;
    }

    /**
     * Get adiscount
     *
     * @return string 
     */
    public function getAdiscount()
    {
        return $this->adiscount;
    }

    /**
     * Set cpanel_package
     *
     * @param string $cpanelPackage
     * @return Product
     */
    public function setCpanelPackage($cpanelPackage)
    {
        $this->cpanel_package = $cpanelPackage;

        return $this;
    }

    /**
     * Get cpanel_package
     *
     * @return string 
     */
    public function getCpanelPackage()
    {
        return $this->cpanel_package;
    }
}
