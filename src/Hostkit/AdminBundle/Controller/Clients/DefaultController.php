<?php

namespace Hostkit\AdminBundle\Controller\Clients;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\CoreBundle\Entity\Client,
    Hostkit\AdminBundle\Form\Type\ClientType,
    Hostkit\AdminBundle\Form\Type\OrderStatusType,
    Hostkit\CoreBundle\Entity\Email,
    Hostkit\EmailBundle\Form\Type\EmailCustomType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package Hostkit\AdminBundle\Controller\Clients
 */
class DefaultController extends Controller {

    public function indexAction() {
        $title = array('name' => 'Clients', 'icon' => 'icon-users');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
        $clients = $repository->findAll(array(), array('id' => 'ASC'));

        return $this->render('HostkitAdminBundle:Clients:index.html.twig', array(
            'clients' => $clients,
            'title' => $title
        ));
    }

    public function writeEmailAction(Request $request, $clientId) {

        $title = array('name' => 'Clients', 'icon' => 'icon-users');
        $emailDetails = array();
        $message = '';

        $form = $this->createForm(new EmailCustomType());

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $requestData = $request->request->all();

                $emailDetails = array(
                    'subject' => $requestData['email']['subject'],
                    'contentTop' => $requestData['email']['contentTop'],
                    'contentInner' => $requestData['email']['contentInner']
                );

                //forward email
                $result = $this->forward('HostkitEmailBundle:Default:sendCustom', array(
                    'emailDetails' => $emailDetails,
                    'clientId'     => $clientId,
                ));

                if($result->getStatusCode() == 200) {
                    $message = 'E-Mail successfully send!';
                }

            }
        }

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
        $client = $repository->find($clientId);

        return $this->render('HostkitAdminBundle:Clients:write_email.html.twig', array(
            'client' => $client,
            'form'    => $form->createView(),
            'message' => $message,
            'title' => $title
        ));
    }

    public function detailAction($clientId) {

        $title = array('name' => 'Clients', 'icon' => 'icon-users');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
        $client = $repository->find($clientId);

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order');
        $orders = $repository->findBy(array('user_id' => $clientId));

        return $this->render('HostkitAdminBundle:Clients:detail.html.twig', array(
            'client' => $client,
            'orders' => $orders,
            'title' => $title
        ));
    }

    public function showInvoiceAction($clientId, $orderId) {

        $title = array('name' => 'Clients', 'icon' => 'icon-users');

        $total = 0;

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
        $client = $repository->find($clientId);

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order');
        $order = $repository->find($orderId);

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings');
        $settings = $repository->find(1);

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Payment');
        $payment = $repository->find(1);

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:OrderItem');
        $orderItems = $repository->findBy(array('order_id' => $orderId));

        foreach($orderItems as $orderItem) {

            $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Product');
            $product = $repository->find($orderItem->getPackageId());

            switch ($orderItem->getPaymentPeriod()) {
                case 1:
                    $total = ($total + number_format(($product->getMonthly() - ($product->getMonthly() / 100 * $product->getMdiscount()) + $product->getMsetup()), 2));
                    break;
                case 3:
                    $total = ($total + number_format(($product->getQuarterly() - ($product->getQuarterly() / 100 * $product->getQdiscount()) + $product->getQsetup()), 2));
                    break;
                case 6:
                    $total = ($total + number_format(($product->getSemiannual() - ($product->getSemiannual() / 100 * $product->getSdiscount()) + $product->getSsetup()), 2));
                    break;
                case 12:
                    $total = ($total + number_format(($product->getAnnual() - ($product->getAnnual() / 100 * $product->getAdiscount()) + $product->getAsetup()), 2));
                    break;
                default:
                    $total = ($total + $orderItem->getPrice());
            }

            if($orderItem->getPackageId() > 0) {
                $product = $this->getDoctrine()->getRepository('HostkitCoreBundle:Product')->find($orderItem->getPackageId());
                $orderItem->setPackageId($product->getName());
            } else {
                $domain = explode(',', $orderItem->getDetails());
                $orderItem->setDetails($domain[0]);
            }
        }

        $total = ($total + $total / 100 * $payment->getVat());

        return $this->render('HostkitAdminBundle:Clients:invoice.html.twig', array(
            'client' => $client,
            'order' => $order,
            'orderItems' => $orderItems,
            'settings' => $settings,
            'payment' => $payment,
            'total' => $total,
            'title' => $title
        ));
    }

    public function changeOrderStatusAction(Request $request, $clientId, $orderId) {

        $message = '';
        $title = array('name' => 'Clients', 'icon' => 'icon-users');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order');
        $order = $repository->find($orderId);

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
        $client = $repository->find($clientId);

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings');
        $settings = $repository->find(1);

        $form = $this->createForm(new OrderStatusType());

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $requestData = $request->request->all();

                $orderStatus = $requestData['order_status']['orderStatus'];
                $reason = $requestData['order_status']['reason'];

                if(isset($requestData['order_status']['sendMail'])) {
                    $sendMail = $requestData['order_status']['sendMail'];
                } else {
                    $sendMail = 0;
                }

                $order->setStatus($orderStatus);

                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

                switch($orderStatus)
                {
                    case (4):
                        if($settings->getAutoJobsHosting() == 1) {
                            $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:OrderItem');
                            $hosting = $repository->findBy(array('order_id' =>$orderId, 'service' => 3));

                            $username = substr(str_replace('.', '', $hosting[0]->getPackageDomain()), 0, 8);
                            $packageInfo = $this->get("hosting.management.service")->getCpanelApi()->suspendacct($username);
                        }

                        if($settings->getAutoJobsdomains() == 1) {
							$result = $this->get("domain.management.service")->suspend($domain[0], $client[0]->getId());
                        }

                        if($sendMail == 0) {
                            $result = $this->forward('HostkitEmailBundle:Default:send', array(
                                'name' => 'account_cancelled',
                                'clientId'     => $clientId,
                            ));

                            if($result->getStatusCode() == 200) {
                                $message .= 'E-Mail successfully send!';
                            }
                        }
                        break;
                }

            }
        }

        return $this->render('HostkitAdminBundle:Clients:order_status.html.twig', array(
            'orders' => $order,
            'client' => $client,
            'form' => $form->createView(),
            'message' => $message,
            'title' => $title
        ));
    }
}
