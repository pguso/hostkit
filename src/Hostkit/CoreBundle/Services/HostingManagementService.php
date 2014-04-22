<?php

/**
 * HostingManagementService.php
 *
 * @category            Hostkit
 * @package             ClientBundle
 * @subpackage          Service
 */

namespace Hostkit\CoreBundle\Services;

use Hostkit\CoreBundle\Services\Library\XmlApi,
    Hostkit\CoreBundle\Services\Library\CpanelApi;

/**
 * Class HostingManagementService
 * @package Hostkit\CoreBundle\Services
 */
class HostingManagementService {

    protected $error;

    protected $accessParams = array();

	/**
	 * @param $container
	 * @param $em
	 */
	public function __construct($container, $em) {
        $this->container = $container;

        $user = $this->container->get('security.context')->getToken()->getUser();

        if ($user != 'anon.') {
            $user_id = $user->getId();
        }

        $serverEntity = 'HostkitCoreBundle:Server';

        $this->em = $em;
        $this->serverEntity = $serverEntity;
        $this->serverRepository = $this->em->getRepository($serverEntity);


        $servers = $this->serverRepository->findBy(array('used' => 1));

        if (!empty($servers)) {
            $host = $servers['0']->getIpAddress();
            $password = $servers['0']->getPassword();
            $username = $servers['0']->getUsername();

            $this->host = $host;
        } else {
            $this->error = '201';
        }

        if (empty($this->error)) {
            $accessParams['host'] = $host;
            $accessParams['password'] = $password;
            $accessParams['username'] = $username;

            $cpanel = new CpanelApi($accessParams);

            /* TODO:Check if Server is cPanel / return 201 if its not cPanel */
            if(is_int($cpanel->connect())) {
                $this->error = 201;
				$this->cpanelApi = 201;
            } else {
                $this->cpanelApi = $cpanel->connect();
            }
        }
    }

	/**
	 * @return XmlApi|int
	 */
	public function getCpanelApi() {
        return $this->cpanelApi;
    }

    public function getIpAddress() {
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

	/**
	 * @return int
	 */
	public function getErrors() {
        return $this->error;
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
        $args_pwd = array('email' => $email, 'domain' => $this->domain, 'password' => $password);

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

	/**
	 * @return int|mixed
	 */
	public function listPackages() {
        if (empty($this->error)) {
            return $this->cpanelApi->listpkgs();
        } else {
            return $this->error;
        }

    }

	/**
	 * @return mixed
	 */
	public function listAccounts() {
        return $this->cpanelApi->listaccts();
    }

}