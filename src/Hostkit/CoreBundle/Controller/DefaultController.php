<?php

namespace Hostkit\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\CoreBundle\Entity\Invoice,
    Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package Hostkit\CoreBundle\Controller
 */
class DefaultController extends Controller {

    /**
     *
     * @return mixed
     */
    public function indexAction() {

        return $this->render('HostkitCoreBundle:Default:index.html.twig', array());
    }

    /**
     * @return Response
     */
    public function domainAvailabilityAction() {
        if (isset($_POST['domainname'])) {
            $url = explode('.', $_POST['domainname']);

            $domain = $url[0];
            $tld = $url[1];
        } else {
            $domain = $_POST['domain'];
            $tld = $_POST['tld'];
        }

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:DomainPricing');

        $domain_price = $repository->findBy(array('tld' => $tld));
        $price = $domain_price[0]->getPriceEuro() . '€';

        $response = array('resultcode' => $this->get("domain.management.service")->domainAvailability($domain . '.' . $tld), 'domain' => $domain . '.' . $tld, 'price' => $price);

        return new Response(json_encode($response));
    }

    /**
     *
     * @return mixed
     */
    public function cronjobAction() {

        $logger = $this->get('logger');
        $counter = 0;

        try {

            $today = new \DateTime();
            $today = $today->format('Y-m-d');
            $recuringPackages = array();
            $em = $this->getDoctrine()->getManager();

            $payment = $this->getDoctrine()->getRepository('HostkitCoreBundle:Payment')->find(1);
            $vat = (integer)$payment->getVat();

            $orderDomainItems = $this->getDoctrine()
                ->getRepository('HostkitCoreBundle:OrderItem')->findBy(array('service' => 2, 'status' => 3));

            $products = $this->getDoctrine()
                ->getRepository('HostkitCoreBundle:Product')->findBy(array('typeId' => 2));

            foreach ($products as $product) {
                $recuringPackages[] = $product->getId();
            }

            $orderHostingItems = $this->getDoctrine()
                ->getRepository('HostkitCoreBundle:OrderItem')->findBy(array('service' => 3, 'status' => 3, 'package_id' => $recuringPackages));

            //throw new \Exception('No order available.');

            if (!empty($orderHostingItems)) {

                foreach ($orderHostingItems as $order) {

                    $product = $this->getDoctrine()->getRepository('HostkitCoreBundle:Product')->find($order->getPackageId());
                    $clientOrder = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order')->find($order->getOrderId());
                    $client = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client')->find($clientOrder->getUserId());

                    $amount = 0;

                    if ($order->getInvoiceDate() == NULL || $order->getInvoiceDate() == '') {
                        $paymentDate = $order->getCreatedAt();
                        $paymentDate = $paymentDate->format('Y-m-d');
                    } else {
                        $paymentDate = $order->getInvoiceDate();
                        $paymentDate = $paymentDate->format('Y-m-d');
                    }

                    $paymentDate = new \DateTime($paymentDate);

                    switch ($order->getPaymentPeriod()) {
                        case 1:
                            $amount = ($product->getMonthly() + $product->getMonthly() / 100 * $vat);
                            $paymentDate = $paymentDate->modify('+1 month');
                            break;
                        case 3:
                            $amount = ($product->getQuarterly() + $product->getMonthly() / 100 * $vat);
                            $paymentDate = $paymentDate->modify('+3 month');
                            break;
                        case 6:
                            $amount = ($product->getSemiannual() + $product->getMonthly() / 100 * $vat);
                            $paymentDate = $paymentDate->modify('+6 month');
                            break;
                        case 12:
                            $amount = ($product->getAnnual() + $product->getMonthly() / 100 * $vat);
                            $paymentDate = $paymentDate->modify('+12 month');
                            break;
                    }

                    $paymentDate = $paymentDate->format('Y-m-d');

                    if ($today == $paymentDate) {

                        $invoice = new Invoice();
                        $invoice->setDate($paymentDate);
                        $invoice->setOrderItemId($order->getId());
                        $invoice->setUserId($order->getUserId());
                        $invoice->setAmount($amount);
                        $invoice->setStatus(1);


                        $em->persist($invoice);
                        $em->flush();

                        $mail = $this->forward('HostkitEmailBundle:Default:send', array(
                            'name'     => 'new_invoice',
                            'clientId' => $client->getId(),
                            'params'   => array('invoiceDue' => $paymentDate)
                        ));

                        if ($mail != 1) {
                            throw new \Exception('Could not send new invoice to client with id: ' . $client->getId() . ', invoice id:' . $invoice->getId());
                        }

                        $counter++;

                    }
                }
            }

            if (!empty($orderDomainItems)) {

                foreach ($orderDomainItems as $order) {

                    $amount = 0;

                    $clientOrder = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order')->find($order->getOrderId());
                    $client = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client')->find($clientOrder->getUserId());


                    if ($order->getInvoiceDate() == NULL || $order->getInvoiceDate() == '') {
                        $paymentDate = $order->getCreatedAt();
                        $paymentDate = $paymentDate->format('Y-m-d');
                    } else {
                        $paymentDate = $order->getInvoiceDate();
                        $paymentDate = $paymentDate->format('Y-m-d');
                    }

                    if (empty($paymentDate)) {
                        throw new \Exception('Could not generate payment date for client with id: ' . $client->getId());
                    }

                    if ($order->getDetails() != '') {
                        $details = explode(',', $order->getDetails());
                    } else {
                        throw new \Exception('Could not get domain data for client with id: ' . $client->getId());
                    }

                    $domain = $this->getDoctrine()->getRepository('HostkitCoreBundle:DomainPricing')->findBy(array('tld' => trim($details[1])));

                    if (!empty($domain)) {
                        $domain = $domain[0];

                        $paymentDate = new \DateTime($paymentDate);

                        switch ($domain->getPeriod()) {
                            case 1:
                                $amount = number_format(($domain->getPrice() + $domain->getPrice() / 100 * $vat), 2);
                                $paymentDate = $paymentDate->modify('+1 year');
                                break;
                            case 2:
                                $amount = number_format(($domain->getPrice() + $domain->getPrice() / 100 * $vat), 2);
                                $paymentDate = $paymentDate->modify('+2 year');
                                break;
                            case 3:
                                $amount = number_format(($domain->getPrice() + $domain->getPrice() / 100 * $vat), 2);
                                $paymentDate = $paymentDate->modify('+3 year');
                                break;
                        }

                        $paymentDate = $paymentDate->format('Y-m-d');
                    }


                    if ('2015-02-16' == $paymentDate) {

                        $invoice = new Invoice();
                        $invoice->setDate($paymentDate);
                        $invoice->setOrderItemId($order->getId());
                        $invoice->setUserId($order->getUserId());
                        $invoice->setAmount($amount);
                        $invoice->setStatus(1);


                        $em->persist($invoice);
                        $em->flush();

                        if (is_int($client->getId()) && !empty($paymentDate)) {
                            $this->forward('HostkitEmailBundle:Default:send', array(
                                'name'     => 'new_invoice',
                                'clientId' => $client->getId(),
                                'params'   => array('invoiceDue' => $paymentDate)
                            ));
                        } else {
                            throw new \Exception('Could not send invoice notification to client.');
                        }


                        $counter++;
                    }
                }
            }

            $logger->error($counter . ' Invoices were generated and send to clients.');

            $paymentTransactions = $this->getDoctrine()->getRepository('HostkitCoreBundle:PaymentTransaction')->findBy(array('paymentStatus' => 'Completed'));

            foreach ($paymentTransactions as $paymentTransaction) {
                $invoices = $this->getDoctrine()->getRepository('HostkitCoreBundle:Invoice')->findBy(array('invoice_id' => $paymentTransaction->getInvoice()));

                foreach ($invoices as $invoice) {

                    $invoice->setStatus(2);

                    $em->persist($invoice);
                    $em->flush();
                }

                $order = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order')->findBy(array('invoice_id' => $paymentTransaction->getInvoice()));

                if (!empty($order)) {
                    $order[0]->setStatus(2);

                    $em->persist($order[0]);
                    $em->flush();
                }


            }


        } catch (\Exception $e) {
            $logger->error(__File__ . '::' . $e->getLine() . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . $e->getMessage());
        }

        return new Response($counter . ' Invoices were generated and send to client.');
    }
}
