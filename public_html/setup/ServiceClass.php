<?php
/*
 * Copyright (c) 2013 Patric Gutersohn
 * http://www.ladensia.com
 *
 */
while (! file_exists('lib') )
    chdir('..');

include_once 'lib/XmlApi.php';  

class ServiceClass {

    public function __construct($host = '', $user = '', $password = '') {

        /////////////////////////////////////////////////////////////////////////
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
        //$domain = 'domain.de'; //add your cpanel domain
        /////////////////////////////////////////////////////////////////////////

        $ssl = 0;
        $this->ssl = $ssl;

        /*
         * TODO - Test for Connection
         */
        $cpanelApi = new XmlApi($this->host, $this->user, $this->password);

        $this->cpanelApi = $cpanelApi;
        $this->whmApi = $cpanelApi;
        $this->password = $password;
        //$this->domain = $domain;

        if($this->ssl == '0') {
            $port = '2082';
            $proto = 'http';

            $port_whm = '2086';

            $this->cpanelApi->set_port($port);
            $this->cpanelApi->set_protocol($proto);

            $this->whmApi->set_port($port_whm);
            $this->whmApi->set_protocol($proto);

        } else if($this->ssl == '1') {
            $port = '2083';
            $proto = 'https';

            $port_whm = '2087';

            $this->cpanelApi->set_port($port);
            $this->cpanelApi->set_protocol($proto);

            $this->whmApi->set_port($port_whm);
            $this->whmApi->set_protocol($proto);
        }

    }
	
	public function setPackages() {
		$small 				= 'habmalne_small';
		$medium 			= 'habmalne_medium';
		$large 				= 'habmalne_l';
		$extralarge 		= 'habmalne_xl';
		$extraextralarge 	= 'habmalne_xxl';
	}

    public function addAccount($user, $domain, $password, $contactemail, $pkgname) {

        $savepkg = 0; 

        $xml = $this->cpanelApi->createacct(array('username' => $user, 'domain' => $domain, 'password' => $password, 'contactemail' => $contactemail, 'plan' => $pkgname, 'savepkg' => $savepkg));

        if($xml->result->statusmsg) {
            $return = $xml->result->statusmsg;
        }

        return $return;
    }

    public function listPackages() {
        return $this->cpanelApi->listpkgs();
    }

}
