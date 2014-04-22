<?php

namespace Hostkit\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;
use Hostkit\ClientBundle\Form\Type\EmailType,
    Hostkit\ClientBundle\Form\Type\IpType,
    Hostkit\ClientBundle\Form\Type\NameserverType,
    Hostkit\ClientBundle\Form\Type\EmailAccountType,
    Hostkit\ClientBundle\Form\Type\DomainForwardType,
    Hostkit\ClientBundle\Form\Type\EmailForwardType;

/**
 * Class InvoiceController
 * @package Hostkit\ClientBundle\Controller
 */
class InvoiceController extends Controller {

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function indexAction() {

        $userId = $this->getUser()->getId();

        $client = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client')->findBy(array('user_id' => $userId));
        $orders = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order')->findBy(array('user_id' => $client[0]->getId()));
        $invoices = $this->getDoctrine()->getRepository('HostkitCoreBundle:Invoice')->findBy(array('userId' => $userId));

        foreach ($orders as $order) {
            $date = new \Datetime($order->getOrderDate());

            $order->setOrderDate($date->format('d-m-Y'));
        }

        foreach ($invoices as $invoice) {
            $date = new \Datetime($invoice->getDate());

            $invoice->setDate($date->format('d-m-Y'));
        }

        return $this->render('HostkitClientBundle:Invoice:index.html.twig', array(
            'invoices' => $invoices,
            'orders'   => $orders
        ));
    }

    public function generatePdfAction($invoiceId) {

        $userId = $this->getUser()->getId();
        $today = new \Datetime('now');
        $today = $today->format('d-m-Y');

        $invoice = $this->getDoctrine()->getRepository('HostkitCoreBundle:Invoice')->find($invoiceId);
        $payment = $this->getDoctrine()->getRepository('HostkitCoreBundle:Payment')->find(1);
        $settings = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings')->find(1);
        $client = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client')->findBy(array('user_id' => $userId));
        $orderItem = $this->getDoctrine()->getRepository('HostkitCoreBundle:OrderItem')->find($invoice->getOrderItemId());

        $orderItem->setCreatedAt($orderItem->getCreatedAt()->format('d-m-Y'));

        if($orderItem->getPackageId() > 0) {
            $product = $this->getDoctrine()->getRepository('HostkitCoreBundle:Product')->find($orderItem->getPackageId());
            $orderItem->setPackageId($product->getName());
        } else {
            $details = explode(',', $orderItem->getDetails());
            $orderItem->setPackageId($details[0]);
        }

        $paymentTill = new \Datetime($invoice->getDate());
        $paymentTill = $paymentTill->format('d-m-Y');

        $invoiceDate = new \Datetime($invoice->getDate());
        $invoiceDate = $invoiceDate->modify('+10 day');
        $invoice->setDate($invoiceDate->format('d-m-Y'));


        $total = number_format(($orderItem->getPrice() + $orderItem->getPrice() * $payment->getVat() / 100), 2);

        $client = $client[0];

        $html = $this->renderView('HostkitClientBundle:Invoice:detail.html.twig', array(
            'invoice'  => $invoice,
            'settings' => $settings,
            'client'   => $client,
            'today'    => $today,
            'orderItem' => $orderItem,
            'payment' => $payment,
            'total' => $total,
            'paymentTill' => $paymentTill
        ));

        //return new Response('generated pdf');
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="file.pdf"'
            )
        );
    }

    public function generateOrderPdfAction($orderId) {

        $userId = $this->getUser()->getId();
        $today = new \Datetime('now');
        $today = $today->format('d-m-Y');
        $total = 0;
        $subtotal = 0;

        $order = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order')->find($orderId);
        $payment = $this->getDoctrine()->getRepository('HostkitCoreBundle:Payment')->find(1);
        $settings = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings')->find(1);
        $client = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client')->findBy(array('user_id' => $userId));
        $orderItems = $this->getDoctrine()->getRepository('HostkitCoreBundle:OrderItem')->findBy(array('order_id' => $order->getId()));

        foreach($orderItems as $orderItem) {
            $orderItem->setCreatedAt($orderItem->getCreatedAt()->format('d-m-Y'));

            if($orderItem->getPackageId() > 0) {
                $product = $this->getDoctrine()->getRepository('HostkitCoreBundle:Product')->find($orderItem->getPackageId());
                $orderItem->setPackageId($product->getName());
            } else {
                $details = explode(',', $orderItem->getDetails());
                $orderItem->setPackageId($details[0]);
            }

            $subtotal = number_format(($subtotal + $orderItem->getPrice()), 2);
            $total = number_format(($subtotal + ($orderItem->getPrice() + $orderItem->getPrice() * $payment->getVat() / 100)), 2);
        }

        $paymentTill = new \Datetime($order->getOrderDate());
        $paymentTill->modify('+10 day');
        $paymentTill = $paymentTill->format('d-m-Y');

        $client = $client[0];

        $html = $this->renderView('HostkitClientBundle:Invoice:detail-order.html.twig', array(
            'order'  => $order,
            'settings' => $settings,
            'client'   => $client,
            'today'    => $today,
            'orderItems' => $orderItems,
            'payment' => $payment,
            'total' => $total,
            'subtotal' => $subtotal,
            'paymentTill' => $paymentTill
        ));

        //return new Response('generated pdf');
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="file.pdf"'
            )
        );
    }

    public function detailAction($invoiceId) {
        $userId = $this->getUser()->getId();
        $today = new \Datetime('now');
        $today = $today->format('d-m-Y');

        $invoice = $this->getDoctrine()->getRepository('HostkitCoreBundle:Invoice')->find($invoiceId);
        $payment = $this->getDoctrine()->getRepository('HostkitCoreBundle:Payment')->find(1);
        $settings = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings')->find(1);
        $client = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client')->findBy(array('user_id' => $userId));
        $orderItem = $this->getDoctrine()->getRepository('HostkitCoreBundle:OrderItem')->find($invoice->getOrderItemId());

        $orderItem->setCreatedAt($orderItem->getCreatedAt()->format('d-m-Y'));

        if($orderItem->getPackageId() > 0) {
            $product = $this->getDoctrine()->getRepository('HostkitCoreBundle:Product')->find($orderItem->getPackageId());
            $orderItem->setPackageId($product->getName());
        } else {
            $details = explode(',', $orderItem->getDetails());
            $orderItem->setPackageId($details[0]);
        }

        $paymentTill = new \Datetime($invoice->getDate());
        $paymentTill = $paymentTill->format('d-m-Y');

        $invoiceDate = new \Datetime($invoice->getDate());
        $invoiceDate = $invoiceDate->modify('+10 day');
        $invoice->setDate($invoiceDate->format('d-m-Y'));


        $total = number_format(($orderItem->getPrice() + $orderItem->getPrice() * $payment->getVat() / 100), 2);

        $client = $client[0];

        return $this->render('HostkitClientBundle:Invoice:detail.html.twig', array(
            'invoice'  => $invoice,
            'settings' => $settings,
            'client'   => $client,
            'today'    => $today,
            'orderItem' => $orderItem,
            'payment' => $payment,
            'total' => $total,
            'paymentTill' => $paymentTill
        ));
    }

}