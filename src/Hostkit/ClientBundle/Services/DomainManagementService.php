<?php

/**
 * DomainManagementService.php
 *
 * @category            Hostkit
 * @package             ClientBundle
 * @subpackage          Service
 */

namespace Hostkit\ClientBundle\Services;

//use Hostkit\ClientBundle\Services\Library\XmlApi;

/**
 * Class DomainManagementService
 * @package Hostkit\ClientBundle\Services
 */
class DomainManagementService {

	/**
	 *
	 */
	public function __construct() {
        $reseller = 'p_guso';
        $username = 'gutersohn_admin';
        $password = 'wtNk4FXYsf';

        $this->reseller = $reseller;
        $this->username = $username;
        $this->password = $password;

        if($reseller == '' || $reseller == NULL) {
            echo 'No Api User is Set';
            header('location: error.php');
        }
    }

	/**
	 * @param $call
	 * @param $commandparams
	 *
	 * @return mixed
	 */private function soapRequest($call, $commandparams) {
        $client = new \SoapClient('https://live.domainbox.net/?WSDL', array('trace' => 1, 'soap_version' => SOAP_1_2));
        //just for testing
        //$client = new SoapClient('https://sandbox.domainbox.net/?wsdl', array('trace' => 1, 'soap_version' => SOAP_1_2));

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

        return $this->soapRequest($call, $commandparams);
    }

	/**
	 * @return mixed
	 */
	public function queryUser() {
        $call = 'QueryUser';

        $commandparams = array('Username' => 'm_still');

        return $this->soapRequest($call, $commandparams);
    }

	/**
	 * @return mixed
	 */
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
	 * @param $domain
	 * @param $client
	 *
	 * @return ResultCode = 102, indicating that the Pre-Order has been successfully placed
	 * @return ResultCode = 101, indicating that the Application has been submitted successfully, but the domain not yet registered
	 * @return ResultCode = 100, indicating that the domain has been successfully registered with these details
	 * @return \Hostkit\ClientBundle\Services\ResultCode ResultCode that does not begin with a 1 indicates that the command failed
	 */
    public function registerDomain($domain, $client) {
    
    	$client = mysqli_fetch_assoc($client);

        $domain_arr = explode(',', $domain); file_put_contents('regdomain.txt', $domain_arr[0]);

        $mailer = new Mailer();
        $db = new Database();
        $settings = $db->getSettings();

        try {

            $period = $this->calculatePeriod($domain_arr[1]);

            //Nameservers
            $nameserver1 = 'ns1.dnsfarm.org';
            $nameserver2 = 'ns2.dnsfarm.org';

            //Contacts, registrant etc.
            $registrant = array('ExistingContact' => array('ContactId' => $settings[19])); //$registrant = array('Name' => '');
            $admin = array('ExistingContact' => array('ContactId' => $settings[19])); //array('Name' => '');
            $tech = array('Name' => $client['firstname'] . ' ' . $client['lastname'], 'Organisation' => $client['company'], 'Street1' => $client['address1'], 'City' => $client['city'], 'State' => $client['state'], 'Postcode' => $client['postcode'], 'Country' => $client['country'], 'CountryCode' => 'US', 'Telephone' => $client['phone'], 'Email' => $client['email']);
            $billing = array('Name' => $client['firstname'] . ' ' . $client['lastname'], 'Organisation' => $client['company'], 'Street1' => $client['address1'], 'City' => $client['city'], 'State' => $client['state'], 'Postcode' => $client['postcode'], 'Country' => $client['country'], 'CountryCode' => 'US', 'Telephone' => $client['phone'], 'Email' => $client['email']);


            //Admin = The administrative contact for the domain //Billing //Tech

            $call = 'RegisterDomain';
            $commandparams = array('DomainName' => $domain_arr[0], 'LaunchPhase' => 'GA', 'AcceptTerms' => true, 'ApplyLock' => false, 'AutoRenew' => false, 'AutoRenewDays' => 30, 'ApplyPrivacy' => false, 'Period' => $period,
                'Nameservers' => array('NS1' => $nameserver1, 'NS2' => $nameserver2,
                    'Contacts' => array('Registrant' => $registrant, 'Admin' => $admin, 'Tech' => $tech, 'Billing' => $billing)

                ));

            $result = $this->soapRequest($call, $commandparams);
            //Todo: delete
            file_put_contents('domain_log.txt', $result);

            if($result != '100' && $result != '101' && $result != '102') {
                throw new Exception('Register Domain failed.');
            }
        } catch (Exception $e) {
            $mailer->sendRawMessage('Register Domain failed', $settings[9], 'Contact your Administrator. Resultcode' . $result->RegisterDomainResult->ResultCode, $db);
        }
	}

	/**
	 * Check the availability of a renew Domain.
	 *
	 * @param $domain
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
	/**
	 * @param $tld
	 *
	 * @return mixed
	 */private function calculatePeriod($tld) {

        $db = new Database();
        $period = $db->getDomainPeriod($tld);

        return $period;
    }

    /*
     * Creates a new contact
     *
     */
	/**
	 * @param $params
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
	/**
	 * @param $contactid
	 * @param $params
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
	/**
	 * @param $contactid
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
	/**
	 * @param        $tld
	 * @param string $mode
	 *
	 * @return mixed
	 */public function getTldPrice($tld, $mode = '') {
        $database = new Database();

        if ($mode == 'transferdomain') {
            $price = $database->tldPriceQuery($tld, $mode);
        } else {
            $price = $database->tldPriceQuery($tld);
        }

        return $price;
    }

}