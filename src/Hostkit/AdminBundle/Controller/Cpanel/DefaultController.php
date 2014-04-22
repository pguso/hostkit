<?php

namespace Hostkit\AdminBundle\Controller\Cpanel;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package Hostkit\AdminBundle\Controller\Cpanel
 */
class DefaultController extends Controller {
	/**
	 * @return mixed
	 */
	public function indexAction() {
        return $this->render('HostkitAdminBundle:Default:dashboard.html.twig', array('name' => ''));
    }

}
