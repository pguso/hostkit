<?php

namespace Hostkit\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response;

/**
 * Class PaymentController
 * @package Hostkit\CoreBundle\Controller
 */
class PaymentController extends Controller {

	/**
	 * @return Response
	 */
	public function vatAction() {

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Payment');

        $payment = $repository->findAll();

        $vat = $payment[0]->getVat();

        return new Response($vat);
    }
}
