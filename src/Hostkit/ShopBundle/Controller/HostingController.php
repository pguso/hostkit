<?php

namespace Hostkit\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request,
    Hostkit\CoreBundle\Entity\Product;

/**
 * Class HostingController
 * @package Hostkit\ShopBundle\Controller
 */
class HostingController extends Controller
{
	/**
	 * @return mixed
	 */
	public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sites = $em->getRepository('HostkitCoreBundle:Site')->findAll();

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Product');
        $packages = $repository->findAll();

        foreach($packages as $package) {
            $description = $package->getDescription();
            $description = explode('|', $description);
            $package->setDescription($description);

			if($package->getMonthly() > 0 && $package->getTypeId() != 3) {
				$package->setPrice(number_format($package->getMonthly(), 2));
				$package->setSetup(number_format($package->getMsetup(), 2));
			} else if($package->getTypeId() == 3) {
                $package->setPrice('0.00');
            }
			
        }

        return $this->render('HostkitShopBundle:Hosting:index.html.twig', array(
            'packages' => $packages,
            'sites' => $sites
        ));
    }
}
