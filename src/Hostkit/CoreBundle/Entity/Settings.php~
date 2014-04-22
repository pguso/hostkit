<?php


namespace Hostkit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile,
	Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="settings")
 */
class Settings {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=155)
     */
    protected $companyName;
	
	/**
     * @ORM\Column(type="string", length=155)
     */
    protected $companyAddress1;
	
	/**
     * @ORM\Column(type="string", length=155)
     */
    protected $companyPostcode;
	
	/**
     * @ORM\Column(type="string", length=155)
     */
    protected $companyCity;
	
	/**
     * @ORM\Column(type="string", length=155)
     */
    protected $companyCountry;

    /**
     * @ORM\Column(type="string", length=155)
     */
    protected $companyState;
	
	/**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    protected $companyOwner;
	
	/**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    protected $companyEmail;

    /**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    protected $supportEmail;
	
	/**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    protected $companyPhone;
	
	/**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $autoJobsDomains;
	
	/**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $autoJobsHosting;
	
	/**
     * @Assert\File(maxSize="6000000")
     */
    protected $logo;
	
	/**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    protected $facebook;
	
	/**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    protected $twitter;
	
	/**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    protected $google;
	
	/**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    protected $domain;

    /**
     * @ORM\Column(type="string", length=600, nullable=true)
     */
    protected $signature;

    /**
     * @ORM\Column(type="string", length=600, nullable=true)
     */
    protected $confirm_url;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    protected $terms_conditions;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $domainReseller;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $domainUser;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $domainPassword;
	
	/**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $UStID;

	public $path = '';

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
     * Set companyName
     *
     * @param string $companyName
     * @return Settings
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set companyAddress1
     *
     * @param string $companyAddress1
     * @return Settings
     */
    public function setCompanyAddress1($companyAddress1)
    {
        $this->companyAddress1 = $companyAddress1;

        return $this;
    }

    /**
     * Get companyAddress1
     *
     * @return string 
     */
    public function getCompanyAddress1()
    {
        return $this->companyAddress1;
    }

    /**
     * Set companyPostcode
     *
     * @param string $companyPostcode
     * @return Settings
     */
    public function setCompanyPostcode($companyPostcode)
    {
        $this->companyPostcode = $companyPostcode;

        return $this;
    }

    /**
     * Get companyPostcode
     *
     * @return string 
     */
    public function getCompanyPostcode()
    {
        return $this->companyPostcode;
    }

    /**
     * Set companyCity
     *
     * @param string $companyCity
     * @return Settings
     */
    public function setCompanyCity($companyCity)
    {
        $this->companyCity = $companyCity;

        return $this;
    }

    /**
     * Get companyCity
     *
     * @return string 
     */
    public function getCompanyCity()
    {
        return $this->companyCity;
    }

    /**
     * Set companyCountry
     *
     * @param string $companyCountry
     * @return Settings
     */
    public function setCompanyCountry($companyCountry)
    {
        $this->companyCountry = $companyCountry;

        return $this;
    }

    /**
     * Get companyCountry
     *
     * @return string 
     */
    public function getCompanyCountry()
    {
        return $this->companyCountry;
    }

    /**
     * Set companyOwner
     *
     * @param string $companyOwner
     * @return Settings
     */
    public function setCompanyOwner($companyOwner)
    {
        $this->companyOwner = $companyOwner;

        return $this;
    }

    /**
     * Get companyOwner
     *
     * @return string 
     */
    public function getCompanyOwner()
    {
        return $this->companyOwner;
    }

    /**
     * Set companyEmail
     *
     * @param string $companyEmail
     * @return Settings
     */
    public function setCompanyEmail($companyEmail)
    {
        $this->companyEmail = $companyEmail;

        return $this;
    }

    /**
     * Get companyEmail
     *
     * @return string 
     */
    public function getCompanyEmail()
    {
        return $this->companyEmail;
    }

    /**
     * Set companyPhone
     *
     * @param string $companyPhone
     * @return Settings
     */
    public function setCompanyPhone($companyPhone)
    {
        $this->companyPhone = $companyPhone;

        return $this;
    }

    /**
     * Get companyPhone
     *
     * @return string 
     */
    public function getCompanyPhone()
    {
        return $this->companyPhone;
    }

    /**
     * Set autoJobsDomains
     *
     * @param integer $autoJobsDomains
     * @return Settings
     */
    public function setAutoJobsDomains($autoJobsDomains)
    {
        $this->autoJobsDomains = $autoJobsDomains;

        return $this;
    }

    /**
     * Get autoJobsDomains
     *
     * @return integer 
     */
    public function getAutoJobsDomains()
    {
        if($this->autoJobsDomains == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set autoJobsHosting
     *
     * @param integer $autoJobsHosting
     * @return Settings
     */
    public function setAutoJobsHosting($autoJobsHosting)
    {
        $this->autoJobsHosting = $autoJobsHosting;

        return $this;
    }

    /**
     * Get autoJobsHosting
     *
     * @return integer 
     */
    public function getAutoJobsHosting()
    {
        if($this->autoJobsHosting == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set logo
     *
     * @param UploadedFile $logo
     * @return Settings
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return UploadedFile 
     */
    public function getLogo()
    {
        return $this->logo;
    }
	
	public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../public_html/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/company';
    }
	
	public function upload()
	{
		// the file property can be empty if the field is not required
		if (null === $this->getLogo()) {
			return;
		}

		// use the original file name here but you should
		// sanitize it at least to avoid any security issues

		// move takes the target directory and then the
		// target filename to move to
		$this->getLogo()->move(
			$this->getUploadRootDir(),
			$this->getLogo()->getClientOriginalName()
		);

		// set the path property to the filename where you've saved the file
		$this->path = $this->getLogo()->getClientOriginalName();

		// clean up the file property as you won't need it anymore
		$this->logo = null;
	}

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Settings
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
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
     * Set twitter
     *
     * @param string $twitter
     * @return Settings
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
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
     * Set google
     *
     * @param string $google
     * @return Settings
     */
    public function setGoogle($google)
    {
        $this->google = $google;

        return $this;
    }

    /**
     * Get google
     *
     * @return string 
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return Settings
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
     * Set signature
     *
     * @param string $signature
     * @return Settings
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return string 
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Set confirm_url
     *
     * @param string $confirmUrl
     * @return Settings
     */
    public function setConfirmUrl($confirmUrl)
    {
        $this->confirm_url = $confirmUrl;

        return $this;
    }

    /**
     * Get confirm_url
     *
     * @return string 
     */
    public function getConfirmUrl()
    {
        return $this->confirm_url;
    }

    /**
     * Set terms_condition
     *
     * @param string $termsCondition
     * @return Settings
     */
    public function setTermsCondition($termsCondition)
    {
        $this->terms_condition = $termsCondition;

        return $this;
    }

    /**
     * Get terms_condition
     *
     * @return string 
     */
    public function getTermsCondition()
    {
        return $this->terms_condition;
    }

    /**
     * Set terms_conditions
     *
     * @param string $termsConditions
     * @return Settings
     */
    public function setTermsConditions($termsConditions)
    {
        $this->terms_conditions = $termsConditions;

        return $this;
    }

    /**
     * Get terms_conditions
     *
     * @return string 
     */
    public function getTermsConditions()
    {
        return $this->terms_conditions;
    }

    /**
     * Set companyState
     *
     * @param string $companyState
     * @return Settings
     */
    public function setCompanyState($companyState)
    {
        $this->companyState = $companyState;

        return $this;
    }

    /**
     * Get companyState
     *
     * @return string 
     */
    public function getCompanyState()
    {
        return $this->companyState;
    }

    /**
     * Set supportEmail
     *
     * @param string $supportEmail
     * @return Settings
     */
    public function setSupportEmail($supportEmail)
    {
        $this->supportEmail = $supportEmail;

        return $this;
    }

    /**
     * Get supportEmail
     *
     * @return string 
     */
    public function getSupportEmail()
    {
        return $this->supportEmail;
    }

    /**
     * Set domainReseller
     *
     * @param string $domainReseller
     * @return Settings
     */
    public function setDomainReseller($domainReseller)
    {
        $this->domainReseller = $domainReseller;

        return $this;
    }

    /**
     * Get domainReseller
     *
     * @return string 
     */
    public function getDomainReseller()
    {
        return $this->domainReseller;
    }

    /**
     * Set domainUser
     *
     * @param string $domainUser
     * @return Settings
     */
    public function setDomainUser($domainUser)
    {
        $this->domainUser = $domainUser;

        return $this;
    }

    /**
     * Get domainUser
     *
     * @return string 
     */
    public function getDomainUser()
    {
        return $this->domainUser;
    }

    /**
     * Set domainPassword
     *
     * @param string $domainPassword
     * @return Settings
     */
    public function setDomainPassword($domainPassword)
    {
        $this->domainPassword = $domainPassword;

        return $this;
    }

    /**
     * Get domainPassword
     *
     * @return string 
     */
    public function getDomainPassword()
    {
        return $this->domainPassword;
    }

    /**
     * Set UStID
     *
     * @param string $uStID
     * @return Settings
     */
    public function setUStID($uStID)
    {
        $this->UStID = $uStID;

        return $this;
    }

    /**
     * Get UStID
     *
     * @return string 
     */
    public function getUStID()
    {
        return $this->UStID;
    }
}
