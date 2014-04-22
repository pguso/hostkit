<?php

namespace Hostkit\CoreBundle\Services\Library;

use Hostkit\CoreBundle\Services\Library\XmlApi;

/**
 * Class CpanelApi
 * @package Hostkit\CoreBundle\Services\Library
 */
class CpanelApi {

    private $debug = false;

    private $host = '127.0.0.1';

    private $hash;

    private $user = 'root';

    private $ssl = 1;

	/**
	 * @param $accessParams
	 */
	public function __construct($accessParams) {
        $this->accessParams = $accessParams;
    }

	/**
	 * @return XmlApi|int
	 */
	public function connect() {
        $cpanelApi = new XmlApi($this->accessParams['host'], $this->accessParams['username'], $this->accessParams['password']);
        $this->cpanelApi = $cpanelApi;

        if ($this->ssl == '0') {
            $port = '2086';
            $proto = 'http';

            $this->cpanelApi->set_port($port);
            $this->cpanelApi->set_protocol($proto);

        } else if ($this->ssl == '1') {
            $port = '2087';
            $proto = 'https';

            $this->cpanelApi->set_port($port);
            $this->cpanelApi->set_protocol($proto);
        }

        if($cpanelApi->listaccts() == NULL) {
            return 201;
        } else if($cpanelApi->listaccts()->statusmsg == 'Cannot Read License File') {
            return 201;
        } else {
            return $this->cpanelApi;
        }

    }


}




