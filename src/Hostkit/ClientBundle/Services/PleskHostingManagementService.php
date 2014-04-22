<?php

/**
 * Returns DOM object representing request for information about all available domains
 * @return DOMDocument
 */
namespace Hostkit\ClientBundle\Services;

use Hostkit\ClientBundle\Services\Library\Plesk\ApiRequestException;

/**
 * Class PleskHostingManagementService
 * @package Hostkit\ClientBundle\Services
 */
class PleskHostingManagementService {

    public function main() {
        //
        // int main()
        //

        $host = '81.30.158.214';
        $login = 'root';
        $password = '3lNFqt8TsK';

        $curl = $this->curlInit($host, $login, $password);

        try {
            $response = $this->sendRequest($curl, $this->domainsInfoRequest()->saveXML());
            $responseXml = $this->parseResponse($response);
            $this->checkResponse($responseXml);

        } catch (ApiRequestException $e) {
            echo $e;
            die();

        }


// Explore the result

        foreach ($responseXml->xpath('/packet/domain/get/result') as $resultNode) {
            echo "Domain id: " . (string)$resultNode->id . " ";
            echo (string)$resultNode->data->gen_info->name . " (" . (string)$resultNode->data->gen_info->dns_ip_address . ")\n";

        }
    }

	/**
	 * @return \DomDocument
	 */
	public function domainsInfoRequest() {

        $xmldoc = new \DomDocument('1.0', 'UTF-8');
        $xmldoc->formatOutput = true;

        // <packet>
        $packet = $xmldoc->createElement('packet');
        $packet->setAttribute('version', '1.4.1.2');
        $xmldoc->appendChild($packet);

        // <packet/domain>
        $domain = $xmldoc->createElement('domain');
        $packet->appendChild($domain);

        // <packet/domain/get>
        $get = $xmldoc->createElement('get');
        $domain->appendChild($get);

        // <packet/domain/get/filter>
        $filter = $xmldoc->createElement('filter');
        $get->appendChild($filter);

        // <packet/domain/get/dataset>
        $dataset = $xmldoc->createElement('dataset');
        $get->appendChild($dataset);

        // dataset elements
        $dataset->appendChild($xmldoc->createElement('limits'));
        $dataset->appendChild($xmldoc->createElement('prefs'));
        $dataset->appendChild($xmldoc->createElement('user'));
        $dataset->appendChild($xmldoc->createElement('hosting'));
        $dataset->appendChild($xmldoc->createElement('stat'));
        $dataset->appendChild($xmldoc->createElement('gen_info'));

        return $xmldoc;

    }

	/**
	 * Prepares CURL to perform Plesk API request
	 *
	 * @param $host
	 * @param $login
	 * @param $password
	 *
	 * @return resource
	 */
    private function curlInit($host, $login, $password)
    {
        $curl = \curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://{$host}:8443/enterprise/control/agent.php");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("HTTP_AUTH_LOGIN: {$login}",
                "HTTP_AUTH_PASSWD: {$password}",
                "HTTP_PRETTY_PRINT: TRUE",
                "Content-Type: text/xml")
        );


        return $curl;

	}

	/**
	 * Performs a Plesk API request, returns raw API response text
	 *
	 * @param $curl
	 * @param $packet
	 * @throws Library\Plesk\ApiRequestException
	 * @return string
*/
    public function sendRequest($curl, $packet)
    {

        curl_setopt($curl, CURLOPT_POSTFIELDS, $packet);
        $result = curl_exec($curl);

        if (curl_errno($curl)) {
            $errmsg = curl_error($curl);
            $errcode = curl_errno($curl);
            curl_close($curl);

            throw new ApiRequestException($errmsg, $errcode);

        }

        curl_close($curl);

        return $result;

	}


	/**
	 * Looks if API responded with correct data
	 *
	 * @param $response_string
	 * @throws Library\Plesk\ApiRequestException
	 * @return SimpleXMLElement
*/
    private function parseResponse($response_string) {

        $xml = new \SimpleXMLElement($response_string);

        if (!is_a($xml, 'SimpleXMLElement'))

            throw new ApiRequestException("Can not parse server response: {$response_string}");

        return $xml;

	}

	/**
	 * Check data in API response
	 * @param \SimpleXMLElement $response
	 * @throws Library\Plesk\ApiRequestException
	 * @return void
*/
    private function checkResponse(\SimpleXMLElement $response) {

        $resultNode = $response->domain->get->result;

        // check if request was successful
        if ('error' == (string)$resultNode->status)

            throw new ApiRequestException("Plesk API returned error: " . (string)$resultNode->result->errtext);

    }

}



