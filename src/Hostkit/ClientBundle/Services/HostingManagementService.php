<?php

/**
 * HostingManagementService.php
 *
 * @category            Hostkit
 * @package             ClientBundle
 * @subpackage          Service
 */

namespace Hostkit\ClientBundle\Services;

use Hostkit\ClientBundle\Services\Library\XmlApi;

/**
 * Class HostingManagementService
 * @package Hostkit\ClientBundle\Services
 */
class HostingManagementService {

	/**
	 * @param $container
	 * @param $em
	 */
	public function __construct($container, $em) {
        $this->container = $container;
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        if($user != 'anon.') {
            $user_id = $user->getId();
        }

        $apiUserEntity = 'HostkitCoreBundle:ApiUser';

        $this->em = $em;
        $this->apiUserEntity = $apiUserEntity;
        $this->apiUserRepository = $this->em->getRepository($apiUserEntity);
        
        $criteria = array('user_id' => $user_id);
        
        $api_user = $this->apiUserRepository->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
        
        $host = $api_user['0']->getIpAddress();
        $user = $api_user['0']->getUsername();
        $password = $api_user['0']->getPassword();
        $domain = $api_user['0']->getDomain();
        
        /*
         * TODO - Test for Connection
         */
        $cpanelApi = new XmlApi($host, $user, $password); 

        $this->cpanelApi = $cpanelApi;
        $this->whmApi = $cpanelApi;
        $this->user = $user;
        $this->password = $password;
        $this->domain = $domain;
        $this->host = $host;
        
        if($api_user['0']->getSsl() == '0') {
            $port = '2082';
            $proto = 'http';

            $port_whm = '2086';
            
            $this->cpanelApi->set_port($port);
            $this->cpanelApi->set_protocol($proto);

            $this->whmApi->set_port($port_whm);
            $this->whmApi->set_protocol($proto);

        } else if($api_user['0']->getSsl() == '1') {
            $port = '2083';
            $proto = 'https';

            $port_whm = '2087';

            $this->cpanelApi->set_port($port);
            $this->cpanelApi->set_protocol($proto);

            $this->whmApi->set_port($port_whm);
            $this->whmApi->set_protocol($proto);
        }
    }
    
    public function getDomainName() {
        return $this->domain;
    }
    
    public function getIPAddress() {
        return $this->host;
    }

	/**
	 * @param       $user
	 * @param       $module
	 * @param       $function
	 * @param array $args
	 */
	public function api2_query($user, $module, $function, $args = array()) {
        $this->cpanelApi->api2_query($user, $module, $function, $args = array());
    }
	
	/*
	 *
	 * Account Functions
	 *
	 */
	/**
	 * @param $search_type
	 * @param $search_term
	 *
	 * @return mixed
	 */
	public function listaccounts($search_type, $search_term) {
		$args = array('api.version' => 1, 'searchtype' => $search_type, 'search' => $search_term);
		
		$accounts = $this->cpanelApi->listaccts($search_type, $search_term);
		
		return $accounts;
	 }
	

    /*
     * 
     * E-Mail Functions
     * 
     */

	/**
	 * @param $email
	 * @param $password
	 * @param $quota
	 *
	 * @return mixed
	 */public function addpop($email, $password, $quota) {
        $module = 'Email';
        $function = 'addpop';
        $args = array('domain' => $this->domain, 'email' => $email, 'password' => $password, 'quota' => $quota);
        $email = $this->cpanelApi->api2_query($this->user, $module, $function, $args);
        
        return $email;
    }

	/**
	 * @param $email
	 * @param $password
	 * @param $quota
	 *
	 * @return array|mixed
	 */public function changepop($email, $password, $quota) {
        $module = 'Email';
        $response = array();
        $email = substr($email, 0, strpos($email, '@'));

        $args_quota = array('email' => $email, 'domain' => $this->domain, 'quota' => $quota);
        $args_pwd = array('email' => $email, 'domain' => $this->domain,  'password' => $password);

        $response = $this->cpanelApi->api2_query($this->user, $module, 'editquota', $args_quota);
        $response = $this->cpanelApi->api2_query($this->user, $module, 'passwdpop', $args_pwd);

        return $response;
    }

	/**
	 * @param $email
	 *
	 * @return mixed
	 */public function delpop($email) {
        $module = 'Email';
        $function = 'delpop';
        $args = array('domain' => $this->domain, 'email' => $email);
        $message = $this->cpanelApi->api2_query($this->user, $module, $function, $args);
        
        return $message;
    }

	/**
	 * @param $email
	 * @param $fwdemail
	 *
	 * @return mixed
	 */public function addforward($email, $fwdemail) {
        $module = 'Email';
        $function = 'addforward';
        $args = array('domain' => $this->domain, 'email' => $email, 'fwdemail' => $fwdemail, 'fwdopt' => 'fwd');
        $email = $this->cpanelApi->api2_query($this->user, $module, $function, $args);
        
        return $email;
    }

	/**
	 * @return mixed
	 */
	public function listpopswithdisk() {
        $module = 'Email';
        $function = 'listpopswithdisk';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args); 
        
        return $list; 
    }

	/**
	 * @return mixed
	 */
	public function listpops() {
        $module = 'Email';
        $function = 'listpops';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);
        
        return $list;
    }

	/**
	 * @return mixed
	 */
	public function listforwards() {
        $module = 'Email';
        $function = 'listforwards';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function listmxs() {
        $module = 'Email';
        $function = 'listmxs';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function filterlist() {
        $module = 'Email';
        $function = 'filterlist';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function listftpwithdisk() {
        $module = 'Ftp';
        $function = 'listftpwithdisk';
        $args = array('domain' => $this->domain, 'dirhtml' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function listsubdomains() {
        $module = 'SubDomain';
        $function = 'listsubdomains';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function listaddondomains() {
        $module = 'AddonDomain';
        $function = 'listaddondomains';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function listredirects() {
        $module = 'Mime';
        $function = 'listredirects';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function listzones() {
        $function = 'dumpzone';
        $args = array('domain' => $this->domain);

        $list = $this->whmApi->xmlapi_query($function, $args); //var_dump($list);die();

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function listdbs() {
        $module = 'MysqlFE';
        $function = 'listdbs';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function listusers() {
        $module = 'MysqlFE';
        $function = 'listusers';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api2_query($this->user, $module, $function, $args);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function lastvisitors() {
        $module = 'Stats';
        $function = 'lastvisitors';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api1_query($this->user, $module, $function);

        return $list;
    }

	/**
	 * @return mixed
	 */
	public function showmanager() {
        $module = 'DiskUsage';
        $function = 'showmanager';
        $args = array('domain' => $this->domain);

        $list = $this->cpanelApi->api1_query($this->user, $module, $function);

        return $list;
    }

}