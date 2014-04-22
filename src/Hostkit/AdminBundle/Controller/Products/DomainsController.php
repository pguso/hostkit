<?php

namespace Hostkit\AdminBundle\Controller\Products;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\CoreBundle\Entity\DomainPricing,
    Hostkit\AdminBundle\Form\Type\DomainType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class DomainsController
 * @package Hostkit\AdminBundle\Controller\Products
 */
class DomainsController extends Controller {

	/**
	 * @return mixed
	 */
	public function indexAction() {
        $title = array('name' => 'Products', 'icon' => 'icon-shopping-cart');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:DomainPricing');
        $domainPricing = $repository->findAll();

        return $this->render('HostkitAdminBundle:Products:index-domains.html.twig', array(
            'domainPricing' => $domainPricing,
            'title' => $title
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
    public function addAction(Request $request) {

        $title = array('name' => 'Products', 'icon' => 'icon-shopping-cart');
        $product = new DomainPricing();

        $form = $this->createForm(new DomainType(), $product);


        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($product);
                //var_dump($eventDate);die();
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_domains_overview'));
            }
        }

        return $this->render('HostkitAdminBundle:Products:add-domain.html.twig', array(
            'form' => $form->createView(),
            'title' => $title
        ));
    }

	/**
	 * @param Request $request
	 * @param         $productId
	 *
	 * @return mixed
	 */
    public function modifyAction(Request $request, $productId) {
        $title = array('name' => 'Products', 'icon' => 'icon-shopping-cart');
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('HostkitCoreBundle:DomainPricing')->find($productId);
        $form = $this->createForm(new DomainType(), $product);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($product);
                //var_dump($eventDate);die();
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_domains_overview'));
            }
        }

        return $this->render('HostkitAdminBundle:Products:add-domain.html.twig', array(
            'form' => $form->createView(),
            'modify' => 1,
            'title' => $title
        ));
    }

	/**
	 * @param $productId
	 *
	 * @return Response
	 */
    public function deleteAction($productId) {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('HostkitCoreBundle:DomainPricing')->find($productId);

        $em->remove($product);
        $em->flush();

        return new Response();
    }
}
