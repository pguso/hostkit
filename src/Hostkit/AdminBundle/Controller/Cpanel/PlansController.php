<?php

namespace Hostkit\AdminBundle\Controller\Cpanel;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PlansController
 * @package Hostkit\AdminBundle\Controller\Cpanel
 */
class PlansController extends Controller {
	/**
	 * @return mixed
	 */
	public function indexAction() {
        return $this->render('HostkitAdminBundle:Cpanel:index-plans.html.twig', array('name' => ''));
    }

	/**
	 * @return mixed
	 */
	public function packagesAction() {
        return $this->render('HostkitAdminBundle:Default:dashboard.html.twig', array('name' => ''));
    }

    public function plansAction() {
        return $this->render('HostkitAdminBundle:Default:dashboard.html.twig', array('name' => ''));
    }

    public function accountsAction() {
        return $this->render('HostkitAdminBundle:Default:dashboard.html.twig', array('name' => ''));
    }
}
