<?php

/**
 * DomainManagementService.php
 *
 * @category            Domain
 * @package             ShopBundle
 * @subpackage          Service
 */

namespace Hostkit\CoreBundle\Services;

use Hostkit\CoreBundle\Services\Library\XmlApi;

/**
 * Class DomainManagementService
 * @package Hostkit\CoreBundle\Services
 */
class Domainbox {

	/**
	 * @param $container
	 * @param $em
	 */
	public function __construct($container, $em) {
        $this->container = $container;
        $this->em = $em;

        if ($user = $this->container->get('security.context')->getToken() != NULL) {
            $user = $this->container->get('security.context')->getToken()->getUser();
        } else {
            $user = 'anon.';
        }


        if ($user != 'anon.') {
            $user_id = $user->getId();
        }

        $reseller = 'p_guso';
        $username = 'gutersohn_admin';
        //$password = 'wtNk4FXYsf'; //live
        $password = '3f&736k%7&';

        $this->reseller = $reseller;
        $this->username = $username;
        $this->password = $password;
    }

	/**
	 * @param $call
	 * @param $commandparams
	 *
	 * @return mixed
	 */private function soapRequest($call, $commandparams) {
        //$client = new \SoapClient('https://live.domainbox.net/?WSDL', array('trace' => 1, 'soap_version' => SOAP_1_2));
        //just for testing
        $client = new \SoapClient('https://sandbox.domainbox.net/?wsdl', array('trace' => 1, 'soap_version' => SOAP_1_2));

        $params = array(
            'AuthenticationParameters' => array(
                'Reseller' => $this->reseller,
                'Username' => $this->username,
                'Password' => $this->password
            ),
            'CommandParameters' => $commandparams
        );

        //$result = $client->CheckDomainAvailability($params);
        $result = $client->__soapCall($call, array($params)); //var_dump($client->__getLastRequest());die();

        return $result;
    }

    /**
     * Check the availability of a Domain Name.
     *
     */
    public function domainAvailability($domain) {
        $call = 'CheckDomainAvailability';
        $commandparams = array('DomainName' => $domain, 'LaunchPhase' => 'GA');

        $result = $this->soapRequest($call, $commandparams);
        $availability = $result->CheckDomainAvailabilityResult->AvailabilityStatusDescr;

        if($availability == 'Available') {
            $resultcode = 100;
        } else {
            $resultcode = 300;
        }

        return $resultcode;
    }

    public function queryUser() {
        $call = 'QueryUser';

        $commandparams = array('Username' => 'm_still');

        return $this->soapRequest($call, $commandparams);
    }

    public function createSub() {
        $call = 'CreateSubReseller';
        $commandparams = array('SubReseller' => 'm_still',
            'AcceptTerms' => true,
            'SubResellerContact' => array('FirstName' => 'patric', 'LastName' => 'patric', 'Street1' => 'udisfuh', 'City' => 'fhsdiu', 'State' => 'husdi', 'Postcode' => '64384', 'CountryCode' => 'DE', 'Telephone' => '47982347', 'Email' => ''),
            //'UserCredentials' => array('Username' => 'patric', 'Password' => 'Jerry007#', 'UserGroupId' => 1),
            'BillingConfig' => array('BillingType' => 'Direct', 'Pricing' => array('PricingTierId' => 3))

        );

        return $this->soapRequest($call, $commandparams);
    }

    /**
     * Check the availability of a Domain Name.
     *
     * @return ResultCode = 102, indicating that the Pre-Order has been successfully placed
     * @return ResultCode = 101, indicating that the Application has been submitted successfully, but the domain not yet registered
     * @return ResultCode = 100, indicating that the domain has been successfully registered with these details
     * @return Any ResultCode that does not begin with a 1 indicates that the command failed
     *
     */
    public function registerDomain($domain, $tld, $client) {

        $settings = $this->em->getRepository('HostkitCoreBundle:Settings')->findBy(array('id' => 1));
        $settings = $settings[0];

        try {

            $period = $this->calculatePeriod($tld);

            //Nameservers
            $nameserver1 = 'ns1.dnsfarm.org';
            $nameserver2 = 'ns2.dnsfarm.org';

            //Contacts, registrant etc.
            $registrant = array(
                'Name' => $settings->getCompanyOwner(),
                'Organisation' => $settings->getCompanyName(),
                'Street1' => $settings->getCompanyAddress1(),
                'City' => $settings->getCompanyCity(),
                'State' => $settings->getCompanyState(),
                'Postcode' => $settings->getCompanyPostcode(),
                'CountryCode' => $settings->getCompanyCountry(),
                'Telephone' => $settings->getCompanyPhone(),
                'Email' => $settings->getCompanyEmail()
            );
            $admin = array('Name' => $settings->getCompanyOwner(),
                'Organisation' => $settings->getCompanyName(),
                'Street1' => $settings->getCompanyAddress1(),
                'City' => $settings->getCompanyCity(),
                'State' => $settings->getCompanyState(),
                'Postcode' => $settings->getCompanyPostcode(),
                'CountryCode' => $settings->getCompanyCountry(),
                'Telephone' => $settings->getCompanyPhone(),
                'Email' => $settings->getCompanyEmail()
            );
            $tech = array(
                'Name' => $client->getFirstname() . ' ' . $client->getLastname(),
                'Organisation' => $client->getCompany(),
                'Street1' => $client->getAddress1(),
                'City' => $client->getCity(),
                'State' => $client->getState(),
                'Postcode' => $client->getPostcode(),
                'CountryCode' => $client->getCountry(),
                'Telephone' => $client->getPhone(),
                'Email' => $client->getEmail()
            );
            $billing = array(
                'Name' => $client->getFirstname() . ' ' . $client->getLastname(),
                'Organisation' => $client->getCompany(),
                'Street1' => $client->getAddress1(),
                'City' => $client->getCity(),
                'State' => $client->getState(),
                'Postcode' => $client->getPostcode(),
                'CountryCode' => $client->getCountry(),
                'Telephone' => $client->getPhone(),
                'Email' => $client->getEmail()
            );

            //Admin = The administrative contact for the domain //Billing //Tech

            $call = 'RegisterDomain';
            $commandparams = array('DomainName' => $domain, 'LaunchPhase' => 'GA', 'AcceptTerms' => true, 'ApplyLock' => false, 'AutoRenew' => false, 'AutoRenewDays' => 30, 'ApplyPrivacy' => false, 'Period' => $period,
                'Nameservers' => array('NS1' => $nameserver1, 'NS2' => $nameserver2,
                    'Contacts' => array('Registrant' => $registrant, 'Admin' => $admin, 'Tech' => $tech, 'Billing' => $billing)

                ));

            $result = $this->soapRequest($call, $commandparams);

var_dump($result);die();
            if($result != '100' && $result != '101' && $result != '102') {
                throw new \Exception('Register Domain failed.');
            }

            return $result;
        } catch (\Exception $e) {
            //$mailer->sendRawMessage('Register Domain failed', $settings[9], 'Contact your Administrator. Resultcode' . $result->RegisterDomainResult->ResultCode, $db);
        }
    }

    /**
     * Check the availability of a renew Domain.
     *
     * @return command will return the new ExpiryDate if successful
     */
    public function renewDomain($domain) {
        $call = 'RenewDomain';
        $commandparams = array('DomainName' => $domain, 'CurrentExpiry' => 'YYYY-MM-DD', 'Period' => 1);

        $this->soapRequest($call, $commandparams);
    }

    /*
     * Calculates the minimum for the given domain tld
     *
     */
    private function calculatePeriod($tld) {

        $domain = $this->em->getRepository('HostkitCoreBundle:DomainPricing')->findBy(array('tld' => trim($tld)));
        $period = $domain[0]->getPeriod();

        return $period;
    }

    /*
     * Creates a new contact
     *
     */
    public function createContact($params) {
        $call = 'CreateContact';
        $commandparams = array('LaunchPhase' => 'GA', 'Contact' => array($params));

        $this->soapRequest($call, $commandparams);
    }

    /*
     * Modify contact
     *
     */
    public function modifyContact($contactid, $params) {
        $call = 'ModifyContact';
        $commandparams = array('ContactId' => $contactid, 'Contact' => array($params));

        $this->soapRequest($call, $commandparams);
    }

    /*
     * Delete contact
     *
     */
    public function deleteContact($contactid) {
        $call = 'DeleteContact';
        $commandparams = array('ContactId' => $contactid);

        $this->soapRequest($call, $commandparams);
    }

    /*
     * Get tld price
     *
     */
    public function getTldPrice($tld, $mode = '') {
        $database = new Database();

        if ($mode == 'transferdomain') {
            $price = $database->tldPriceQuery($tld, $mode);
        } else {
            $price = $database->tldPriceQuery($tld);
        }

        return $price;
    }
}