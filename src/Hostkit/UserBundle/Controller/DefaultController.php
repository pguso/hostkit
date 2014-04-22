<?php

namespace Hostkit\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package Hostkit\UserBundle\Controller
 */
class DefaultController extends Controller
{
	/**
	 * @param $name
	 *
	 * @return mixed
	 */public function indexAction($name)
    {
        return $this->render('HostkitUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
