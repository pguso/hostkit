<?php

namespace Hostkit\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HostingController
 * @package Hostkit\ClientBundle\Controller
 */
class HostingController extends Controller
{   
    /*
     * 
     * connects to the cpanel api
     * 
     */
	/**
	 * @return mixed
	 */
	public function indexAction()
    {
            $hosting_service = $this->container->get('hosting.management.service');

        $userId = $this->getUser()->getId();

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');

        $activeItems = $repository->findBy(array('user_id' => $userId, 'service' => 3));

        foreach ($activeItems as $activeItem) {
            $activeItem->setCreatedAt($activeItem->getCreatedAt()->format('Y-m-d'));

            $package = $this->getDoctrine()
                ->getRepository('HostkitCoreBundle:Product')->find($activeItem->getPackageId());

            $activeItem->setPackageId($package->getName());

        }

        $server = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Server')->findBy(array('status' => 1));


        return $this->render('HostkitClientBundle:Hosting:index.html.twig', array(
            'activeItems' => $activeItems,
            'server' => $server[0]
        ));

    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function configAction($packageId) {


        return $this->render('HostkitClientBundle:Hosting:config.html.twig', array(
            'domainId' => $packageId
        ));
    }
}
