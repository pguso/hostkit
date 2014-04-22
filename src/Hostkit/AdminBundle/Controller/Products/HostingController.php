<?php

namespace Hostkit\AdminBundle\Controller\Products;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\CoreBundle\Entity\Product,
    Hostkit\AdminBundle\Form\Type\ProductType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class HostingController
 * @package Hostkit\AdminBundle\Controller\Products
 */
class HostingController extends Controller
{

    /**
     * @return mixed
     */
    public function indexAction()
    {
        $title = array('name' => 'Products', 'icon' => 'icon-shopping-cart');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Product');
        $hostingPackages = $repository->findAll();

        return $this->render('HostkitAdminBundle:Products:index-hosting.html.twig', array(
            'hostingPackages' => $hostingPackages,
            'title' => $title
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function addAction(Request $request)
    {

        $title = array('name' => 'Products', 'icon' => 'icon-shopping-cart');
        $product = new Product();
        $packageList = '';
        $packages = array();

        if ($this->get("hosting.management.service")->getErrors() != 201) {
            $packages = $this->get("hosting.management.service")->listPackages();
        }

        if (is_object($packages)) {
            foreach ($packages as $package) {
                $index = (string)$package->name;
                $packageList[$index] = (string)$package->name;
            }

            $form = $this->createForm(new ProductType(), $product, array('attr' => $packageList));
        } else {
            $form = $this->createForm(new ProductType(), $product);
        }



        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $requestData = $request->request->all();
                $description = array($requestData['product']['webspace'] . ' MB Webspace', $requestData['product']['traffic'] . ' MB Traffic', $requestData['product']['databases'] . ' MySQL Databases', $requestData['product']['ftp'] . ' FTP Accounts', $requestData['product']['email'] . ' E-Mail Addresses');
                $description = implode('|', $description);
                $product->setDescription($description);
                $product->setQuarterly($product->getQuarterly() * 3);
                $product->setSemiannual($product->getSemiannual() * 6);
                $product->setAnnual($product->getAnnual() * 12);

                $product->setCreatedAt(date("d.m.Y H:i"));

                $em->persist($product);
                //var_dump($eventDate);die();
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_hosting_overview'));
            }
        }

        return $this->render('HostkitAdminBundle:Products:add-hosting.html.twig', array(
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
    public function modifyAction(Request $request, $productId)
    {
        $title = array('name' => 'Products', 'icon' => 'icon-shopping-cart');
        $packageList = '';
        $packages = array();

        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('HostkitCoreBundle:Product')->find($productId);
        $product->setQuarterly($product->getQuarterly() / 3);
        $product->setSemiannual($product->getSemiannual() / 6);
        $product->setAnnual($product->getAnnual() / 12);

        if ($this->get("hosting.management.service")->getErrors() != 201) {
            $packages = $this->get("hosting.management.service")->listPackages();
        }

        if (is_object($packages)) {
            foreach ($packages as $package) {
                $index = (string)$package->name;
                $packageList[$index] = (string)$package->name;
            }

            $form = $this->createForm(new ProductType(), $product, array('attr' => $packageList));
        } else {
            $form = $this->createForm(new ProductType(), $product);
        }

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $requestData = $request->request->all();

                $description = array($requestData['product']['webspace'] . ' MB Webspace', $requestData['product']['traffic'] . ' MB Traffic', $requestData['product']['databases'] . ' MySQL Databases', $requestData['product']['ftp'] . ' FTP Accounts', $requestData['product']['email'] . ' E-Mail Addresses');
                $product->setDescription(implode('|', $description));
                $product->setQuarterly($product->getQuarterly() * 3);
                $product->setSemiannual($product->getSemiannual() * 6);
                $product->setAnnual($product->getAnnual() * 12);

                $em->persist($product);
                //var_dump($eventDate);die();
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_hosting_overview'));
            }
        }

        $rec = $product->getTypeId();

        return $this->render('HostkitAdminBundle:Products:add-hosting.html.twig', array(
            'form' => $form->createView(),
            'description' => explode('|', $product->getDescription()),
            'modify' => 1,
            'rec' => $rec,
            'title' => $title
        ));
    }

    /**
     * @param $productId
     *
     * @return Response
     */
    public function deleteAction($productId)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('HostkitCoreBundle:Product')->find($productId);

        $em->remove($product);
        $em->flush();

        return new Response();
    }
}
