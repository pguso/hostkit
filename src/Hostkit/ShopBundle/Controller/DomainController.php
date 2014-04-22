<?php

namespace Hostkit\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller, Symfony\Component\HttpFoundation\Response, Symfony\Component\HttpFoundation\Request, Hostkit\CoreBundle\Entity\Product;

/**
 * Class DomainController
 * @package Hostkit\ShopBundle\Controller
 */
class DomainController extends Controller {

	/**
	 * @return mixed
	 */
	public function indexAction() {
        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:DomainPricing');

        $domains = $repository->findBy(array(), array('tld'=>'asc'));

        return $this->render('HostkitShopBundle:Domain:index.html.twig', array(
            'domains' => $domains
        ));
    }
}
