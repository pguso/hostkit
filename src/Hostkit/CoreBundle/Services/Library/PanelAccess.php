<?php

namespace Hostkit\CoreBundle\Services\Library;

/**
 * Class PanelAccess
 * @package Hostkit\CoreBundle\Services\Library
 */
class PanelAccess {

    private $debug = false;

    private $host = '127.0.0.1';

    private $hash;

    // username to authenticate as
    private $user = 'root';

	/**
	 * @param $params
	 */
	public function __construct($params) {
        $this->params = $params;
    }

    public function cpanel() {
        $whmusername = "root";
        $whmhash = "somelonghash";
        # some hash value

        $query = "https://127.0.0.1:2087/....";

        $curl = curl_init();
        # Create Curl Object
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
        # Allow certs that do not match the domain
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
        # Allow self-signed certs
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        # Return contents of transfer on curl_exec
        $header[0] = "Authorization: WHM $whmusername:" . preg_replace("'(\r|\n)'","",$whmhash);
        # Remove newlines from the hash
        curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
        # Set curl header
        curl_setopt($curl, CURLOPT_URL, $query);
        # Set your URL
        $result = curl_exec($curl);
        # Execute Query, assign to $result
        if ($result == false) {
            error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
        }
        curl_close($curl);

        print $result;
    }


}




