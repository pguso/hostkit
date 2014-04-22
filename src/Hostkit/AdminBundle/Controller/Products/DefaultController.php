<?php

namespace Hostkit\AdminBundle\Controller\Products;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package Hostkit\AdminBundle\Controller\Products
 */
class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('HostkitAdminBundle:Products:index-hosting.html.twig', array('name' => ''));
    }
}
