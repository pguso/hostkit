<?php


namespace Hostkit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="payment_transaction")
 */
class PaymentTransaction
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
    protected $provider;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $invoice;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $residenceCountry;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $paymentDate;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $tax;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $verifySign;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $payerEmail;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $txnType;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $payerStatus;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $mcCurrency;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $paymentType;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $paymentStatus;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    protected $addressStatus;


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
     * Set provider
     *
     * @param string $provider
     * @return PaymentTransaction
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return string 
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set invoice
     *
     * @param string $invoice
     * @return PaymentTransaction
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return string 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set residenceCountry
     *
     * @param string $residenceCountry
     * @return PaymentTransaction
     */
    public function setResidenceCountry($residenceCountry)
    {
        $this->residenceCountry = $residenceCountry;

        return $this;
    }

    /**
     * Get residenceCountry
     *
     * @return string 
     */
    public function getResidenceCountry()
    {
        return $this->residenceCountry;
    }

    /**
     * Set paymentDate
     *
     * @param string $paymentDate
     * @return PaymentTransaction
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return string 
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set tax
     *
     * @param string $tax
     * @return PaymentTransaction
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return string 
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set verifySign
     *
     * @param string $verifySign
     * @return PaymentTransaction
     */
    public function setVerifySign($verifySign)
    {
        $this->verifySign = $verifySign;

        return $this;
    }

    /**
     * Get verifySign
     *
     * @return string 
     */
    public function getVerifySign()
    {
        return $this->verifySign;
    }

    /**
     * Set payerEmail
     *
     * @param string $payerEmail
     * @return PaymentTransaction
     */
    public function setPayerEmail($payerEmail)
    {
        $this->payerEmail = $payerEmail;

        return $this;
    }

    /**
     * Get payerEmail
     *
     * @return string 
     */
    public function getPayerEmail()
    {
        return $this->payerEmail;
    }

    /**
     * Set txnType
     *
     * @param string $txnType
     * @return PaymentTransaction
     */
    public function setTxnType($txnType)
    {
        $this->txnType = $txnType;

        return $this;
    }

    /**
     * Get txnType
     *
     * @return string 
     */
    public function getTxnType()
    {
        return $this->txnType;
    }

    /**
     * Set payerStatus
     *
     * @param string $payerStatus
     * @return PaymentTransaction
     */
    public function setPayerStatus($payerStatus)
    {
        $this->payerStatus = $payerStatus;

        return $this;
    }

    /**
     * Get payerStatus
     *
     * @return string 
     */
    public function getPayerStatus()
    {
        return $this->payerStatus;
    }

    /**
     * Set mcCurrency
     *
     * @param string $mcCurrency
     * @return PaymentTransaction
     */
    public function setMcCurrency($mcCurrency)
    {
        $this->mcCurrency = $mcCurrency;

        return $this;
    }

    /**
     * Get mcCurrency
     *
     * @return string 
     */
    public function getMcCurrency()
    {
        return $this->mcCurrency;
    }

    /**
     * Set paymentType
     *
     * @param string $paymentType
     * @return PaymentTransaction
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return string 
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set paymentStatus
     *
     * @param string $paymentStatus
     * @return PaymentTransaction
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * Get paymentStatus
     *
     * @return string 
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set addressStatus
     *
     * @param string $addressStatus
     * @return PaymentTransaction
     */
    public function setAddressStatus($addressStatus)
    {
        $this->addressStatus = $addressStatus;

        return $this;
    }

    /**
     * Get addressStatus
     *
     * @return string 
     */
    public function getAddressStatus()
    {
        return $this->addressStatus;
    }
}
