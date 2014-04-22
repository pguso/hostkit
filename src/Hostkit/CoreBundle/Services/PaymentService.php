<?php

/**
 * DomainManagementService.php
 *
 * @category            Payment
 * @package             CoreBundle
 * @subpackage          Service
 */

namespace Hostkit\CoreBundle\Services;

use Hostkit\CoreBundle\Services\Library\Paypal;

/**
 * Class PaymentService
 * @package Hostkit\CoreBundle\Services
 */
class PaymentService {

	public function paypalIpn() {
		// Create an instance of the paypal library
		$paypal = new Paypal();

		// Log the IPN results
		$paypal->ipnLog = TRUE;

		$db = new Database();


		$params = array('', $_POST['invoice'], $_POST['residence_country'], $_POST['payment_date'], $_POST['tax'], $_POST['verify_sign'], $_POST['payer_email'], $_POST['txn_type'],
			$_POST['payer_status'], $_POST['mc_currency'], $_POST['payment_type'], $_POST['payment_status'], $_POST['address_status']);


	}

}