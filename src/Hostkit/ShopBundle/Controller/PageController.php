<?php 

namespace Hostkit\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,    	
	Hostkit\CoreBundle\Entity\Site,
	Symfony\Component\HttpFoundation\Response,    	
	Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 * @package Hostkit\ShopBundle\Controller
 */
class PageController extends Controller {

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
    public function indexAction($name) {

		$em = $this->getDoctrine()->getManager();
        $sites = $em->getRepository('HostkitCoreBundle:Site')->findAll();
		
		$repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Site');
		$page = $repository->findBy(array('name' => $name), array(), 1);        
		
		return $this->render('HostkitShopBundle:Page:index.html.twig', array(
			'page' => $page,
			'sites' => $sites
		));    		
	}
}