<?php

/**
 * DomainManagementService.php
 *
 * @category            Domain
 * @package             ShopBundle
 * @subpackage          Service
 */

namespace Hostkit\CoreBundle\Services;

use Hostkit\CoreBundle\Services\Library\Resellerclub;

/**
 * Class DomainManagementService
 * @package Hostkit\CoreBundle\Services
 */
class DomainManagementService {

    protected $em;
    protected $container;
    protected $domainApi;
    protected $entity;
    protected $settings;
    protected $customerId;
    protected $contactId;

    public function __construct($container, $em) {
        $this->container = $container;
        $this->em = $em;

        $this->settings = $this->em->getRepository('HostkitCoreBundle:Settings')->find(1);

        //TODO:implement domainox api and add condition / setting for admin
        $this->domainApi = new Resellerclub($this->settings->getDomainReseller(), $this->settings->getDomainPassword());
    }

    public function domainAvailability($domain, $tld) {

        $result = $this->domainApi->submit('domains/available', array(
            'domain-name' => $domain,
            'tlds' => $tld
        ), 'GET');
        //100 ok //300 nicht ok

        $result = json_decode($result);

        $domain = $domain . '.' . $tld;

        if($result->$domain->status == 'available') {
            $result = 100;
        } else {
            $result = 300;
        }

        return $result;
    }

    public function register($domain, $clientId) {

        $this->addContact();
        $this->addCustomer($clientId);
		
        $result = $this->domainApi->submit('domains/register', array(
            'domain-name' => $domain,
            'years' => 1,
            'ns' => array('dns1.directi.com', 'dns2.directi.com'),
            'customer-id' =>  10763494,
            'reg-contact-id' => 33445260,
            'admin-contact-id' => 33445260,
            'tech-contact-id' => 33445260,
            'billing-contact-id' => 33445260,
            'invoice-option' => 'NoInvoice',
            'protect-privacy' => true
        ), 'POST');
		
		$orderId = $this->getOrderId($domain);
		$this->activateFreeEmailService($orderId);

        $result = json_decode($result);

        return $result;
    }
	
	public function suspend($domain, $clientId) {
	
		$orderId = $this->getOrderId($domain);
	
		$result = $this->domainApi->submit('orders/suspend', array(
            'order-id' => $orderId,
            'reason' => 'Client requested cancellation.'
        ), 'POST');

        return $result;
	}
	
	public function getOrderId($domain) {
	
		$result = $this->domainApi->submit('domains/orderid', array(
            'domain-name' => $domain
        ), 'GET');
		
		$result = json_decode($result);

        return $result;
	}

    public function addCustomer($clientId) {

        $client = $this->em->getRepository('HostkitCoreBundle:Client')->find($clientId);

        $this->customerId = $this->domainApi->submit('customers/signup', array(
            'username' => $client->getEmail(),
            'passwd' => 'jerry007',
            'name' => 'firstname lastname',
            'company' => 'company',
            'address-line-1' => 'address1',
            'city' => 'city',
            'state' => 'state',
            'country' => 'US',
            'zipcode' => '71679',
            'phone-cc' => '49',
            'phone' => '9088032',
            'lang-pref' => 'en'
        ), 'POST');
    }

    public function addContact() {

        $this->contactId = $this->domainApi->submit('contacts/add', array(
            'name' => $this->settings->getCompanyOwner(),
            'email' => $this->settings->getCompanyemail(),
            'company' => $this->settings->getCompanyName(),
            'address-line-1' => $this->settings->getCompanyAddress1(),
            'city' => $this->settings->getCompanyCity(),
            'state' => $this->settings->getCompanyState(),
            'country' => 'US',
            'zipcode' => $this->settings->getCompanyPostcode(),
            'phone-cc' => '49',
            'phone' => $this->settings->getCompanyPhone(),
            'customer-id' => $this->customerId,
            'type' => 'Contact',
            'attr-value' => array('attr-name1' =>'locality', 'attr-value1' => 'us'),
            'lang-pref' => 'en'
        ), 'POST');
    }

    public function addMailAccount($domain, $params) {

        $orderId = $this->getOrderId($domain);

        $userDetails = $this->domainApi->submit('mail/user/add', array(
            'order-id' => $orderId,
            'email' => $params['email'] . '@' . $domain,
            'passwd' => $params['passwd'],
            'notification-email' => $params['notification'],
            'first-name' => $params['firstname'],
            'lastname' => $params['lastname'],
            'country-code' => 'US',
            'language-code' => 'en'
        ), 'POST');

        $userDetails = json_decode($userDetails);

		return $userDetails;
    }

    public function addMailForward($domain, $params) {

        $orderId = $this->getOrderId($domain);

        $userDetails = $this->domainApi->submit('mail/user/add-forward-only-account', array(
            'order-id' => $orderId,
            'email' => $params['email'] . '@' . $domain,
            'forwards' => $params['forward']
        ), 'POST');

        $userDetails = json_decode($userDetails);

        return $userDetails;
    }

    public function detailsDomainForward($domain) {

        $orderId = $this->getOrderId($domain);

        $response = $this->domainApi->submit('domainforward/details', array(
            'order-id' => $orderId
        ), 'GET');

        $response = json_decode($response);

        return $response;
    }

    public function dnsDetails($domain, $type, $host = '') {

        $records = array();

        $response = $this->domainApi->submit('dns/manage/search-records', array(
            'domain-name' => $domain,
            'type' => $type,
			'host' => $host,
            'no-of-records' => 10,
            'page-no' => 1
        ), 'GET');

        $response = json_decode($response);

        foreach($response as $record) {

            if(!is_int($record)) {
                $records[] = $record;
            }
        }

        return $records;
    }

    public function modifyNameserver($domain, $params) {

        $response = $this->domainApi->submit('dns/manage/update-ns-record', array(
            'domain-name' => $domain,
            'host' => $params['host'],
            'current-value' => $params['current'],
            'new-value' => $params['new']
        ), 'POST');

        $response = json_decode($response);

        return $response;
    }

    public function addNameserver($domain, $params) {

        $response = $this->domainApi->submit('dns/manage/add-ns-record', array(
            'domain-name' => $domain,
            'host' => $params['host'],
            'value' => $params['new']
        ), 'POST');

        $response = json_decode($response);

        return $response;
    }

    public function addIp4($domain, $params) {

        $response = $this->domainApi->submit('dns/manage/add-ipv4-record', array(
            'domain-name' => $domain,
            'value' => $params['value'],
			'host' => $params['host']
        ), 'POST');

        $response = json_decode($response);

        return $response;
    }

    public function modifyIp4($domain, $params) {

		if(isset($params['host'])) {
			$response = $this->domainApi->submit('dns/manage/update-ipv4-record', array(
				'domain-name' => $domain,
				'host' => $params['host'],
				'current-value' => $params['current'],
				'new-value' => $params['new']
			), 'POST');
		} else {
			$this->domainApi->submit('dns/manage/update-ipv4-record', array(
				'domain-name' => $domain,
				'host' => 'www',
				'current-value' => $params['current'],
				'new-value' => $params['new']
			), 'POST');

			$response = $this->domainApi->submit('dns/manage/update-ipv4-record', array(
				'domain-name' => $domain,
				'current-value' => $params['current'],
				'new-value' => $params['new']
			), 'POST');
		
		}

        $response = json_decode($response);

        return $response;
    }

    public function addDomainForward($domain, $params) {

        $orderId = $this->getOrderId($domain);

        $response = $this->domainApi->submit('domainforward/manage', array(
            'order-id' => $orderId,
            'forward-to' => $params['forward'],
            'url-masking' => $params['masking'],
            'sub-domain-forwarding' => $params['sub'],
            'path-forwarding' => $params['path']
        ), 'POST');

        $response = json_decode($response);

        return $response;
    }
	
	public function activateFreeEmailService($orderId) {
	
		$this->response = $this->domainApi->submit('mail/activate', array(
            'order-id' => $orderId
        ), 'POST');
	}

    public function searchEmail($domain, $type) {

        $orderId = $this->getOrderId($domain);
        $emailAddressesTmp = array();

        $emailAddresses = $this->domainApi->submit('mail/users/search', array(
            'order-id' => $orderId,
            'account-types' => $type
        ), 'GET');

        $emailAddresses = json_decode($emailAddresses);

        if($emailAddresses->response->status == 'SUCCESS') {
            if(empty($type)) {
                foreach($emailAddresses->response->users as $emailAddress) {
                    if($emailAddress->accountType == 'POP_WITHOUT_AUTORESPONDER') {
                        $emailAddressesTmp[] = $emailAddress;
                    }
                }

                return $emailAddressesTmp;
            } else {
                $emailAddresses = $emailAddresses->response->users;
            }
        }

        return $emailAddresses;
    }
	
	public function domainForwarding($domain, $params) {
	
		$orderId = $this->getOrderId($domain);
	
		$this->response = $this->domainApi->submit('domainforward/manage', array(
            'order-id' => $orderId,
			'forward-to' => $params['forward'],
			'sub-domain-forwarding' => $params['sub']
        ), 'POST');
		
		return $this->response;
	}
	
	public function dnsRecords($domain) {
	
	
		$this->response = $this->domainApi->submit('domainforward/dns-records', array(
            'domain-name' => $domain,
        ), 'GET');
		
		return $this->response;
	}
	
	public function addDomainAlias($domain, $params) {
	
		$orderId = $this->getOrderId($domain);
	
		$this->response = $this->domainApi->submit('mail/domain/add-alias', array(
            'order-id' => $orderId,
			'alias' => $params['alias']
        ), 'POST');
		
		return $this->response;
	}
}