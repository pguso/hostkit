<?php

namespace Hostkit\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\JsonResponse,
    Symfony\Component\HttpFoundation\Session\Session,
    Hostkit\CoreBundle\Entity\Cart,
    Hostkit\CoreBundle\Entity\Order,
    Hostkit\CoreBundle\Entity\OrderItem,
    Hostkit\CoreBundle\Entity\PaymentTransaction,
    Hostkit\ShopBundle\Form\Type\CheckoutType,
    Hostkit\CoreBundle\Services\Library\Paypal,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class PaymentController
 * @package Hostkit\ShopBundle\Controller
 */
class PaymentController extends Controller {

    /**
     * @return RedirectResponse
     */
    public function paypalAction() {
        $session = $this->get('session');
        $sessionId = $session->getId();
        $items = array();
        $vat = (int)$this->forward('HostkitCoreBundle:Payment:vat')->getContent();

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Cart');

        $cart = $repository->findBy(array('sessionId' => $sessionId));

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Client');

        $client = $repository->findBy(array('id' => $cart[0]->getClientId()));

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Product');

        $product = $repository->findBy(array('id' => $cart[0]->getProductId()));

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:DomainPricing');

        $domainPricing = $repository->findBy(array('tld' => $cart[0]->getTld()));

        $clientOrder = new Order();

        if (!empty($domainPricing)) {
            $domainPricing = $domainPricing[0]->getPrice();
        } else {
            $domainPricing = 0;
        }

        switch ($cart[0]->getBillingCycle()) {
            case 1:
                $amount = (number_format(($product[0]->getMonthly() - ($product[0]->getMonthly() / 100 * $product[0]->getMdiscount()) + $product[0]->getMsetup()), 2) + $domainPricing);
                break;
            case 3:
                $amount = (number_format(($product[0]->getQuarterly() - ($product[0]->getQuarterly() / 100 * $product[0]->getQdiscount()) + $product[0]->getQsetup()), 2) + $domainPricing);
                break;
            case 6:
                $amount = (number_format(($product[0]->getSemiannual() - ($product[0]->getSemiannual() / 100 * $product[0]->getSdiscount()) + $product[0]->getSsetup()), 2) + $domainPricing);
                break;
            case 12:
                $amount = (number_format(($product[0]->getAnnual() - ($product[0]->getAnnual() / 100 * $product[0]->getAdiscount()) + $product[0]->getAsetup()), 2) + $domainPricing);
                break;
            default:
                $amount = ($product[0]->getPrice() + $domainPricing);
        }

        $amount = number_format(($amount / 100 * $vat + $amount), 2);

        $unique_id = uniqid();

        //Save Client Order to DB
        $clientOrder->setOrderDate(date('d-m-Y H:i'));
        $clientOrder->setStatus(1);
        $clientOrder->setAmount($amount);
        $clientOrder->setInvoiceId($unique_id);
        $clientOrder->setUserId($client[0]->getId()); //is not user id!TODO:rename in database!
        $clientOrder->setOrderDate(date('d-m-Y H:i'));
        $clientOrder->setOrderDate(date('d-m-Y H:i'));
        $clientOrder->setOrderDate(date('d-m-Y H:i'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($clientOrder);
        $em->flush();

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Payment');

        $payment = $repository->findBy(array('provider' => 'paypal'));

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings');

        $settings = $repository->findBy(array('id' => 1));

        //Generate Paypal URL
        $urlParams = "?notify_url=" . urlencode($payment[0]->getNotifyUrl());
        $urlParams .= "&upload=1";
        $urlParams .= "&charset=utf-8";
        $urlParams .= "&currency_code=" . $payment[0]->getCurrencyCode();
        $urlParams .= "&business=" . $payment[0]->getEmail();
        $urlParams .= "&return_url=" . $payment[0]->getReturnUrl() . "&";
        $urlParams .= "&cmd=_cart";
        $urlParams .= "&invoice=" . $unique_id;

        $i = 1;

        if ($product[0]->getTypeId() == 1) {
            $items[0] = array('service' => 'Hosting Package ' . $product[0]->getName(), 'amount' => $product[0]->getPrice());
        } else if ($product[0]->getTypeId() == 2) {

            switch ($cart[0]->getBillingCycle()) {
                case 1:
                    $items[0] = array('service' => 'Hosting Package ' . $product[0]->getName(), 'amount' => number_format(($product[0]->getMonthly() - ($product[0]->getMonthly() / 100 * $product[0]->getMdiscount()) + $product[0]->getMsetup()), 2));
                    break;
                case 3:
                    $items[0] = array('service' => 'Hosting Package ' . $product[0]->getName(), 'amount' => number_format(($product[0]->getQuarterly() - ($product[0]->getQuarterly() / 100 * $product[0]->getQdiscount()) + $product[0]->getQsetup()), 2));
                    break;
                case 6:
                    $items[0] = array('service' => 'Hosting Package ' . $product[0]->getName(), 'amount' => number_format(($product[0]->getSemiannual() - ($product[0]->getSemiannual() / 100 * $product[0]->getSdiscount()) + $product[0]->getSsetup()), 2));
                    break;
                case 12:
                    $items[0] = array('service' => 'Hosting Package ' . $product[0]->getName(), 'amount' => number_format(($product[0]->getAnnual() - ($product[0]->getAnnual() / 100 * $product[0]->getAdiscount()) + $product[0]->getAsetup()), 2));
                    break;
            }
        } else {
            $items[0] = array('service' => 'Hosting Package ' . $product[0]->getName(), 'amount' => 0);
        }

        if ($cart[0]->getDomainMode() != 'owndomain') {
            $items[1] = array('service' => 'Domain ' . $cart[0]->getDomain() . '.' . $cart[0]->getTld(), 'amount' => $domainPricing);
        }

        $hostingItem = new OrderItem();

        switch ($cart[0]->getBillingCycle()) {
            case 1:
                $hostingItem->setPrice(number_format(($product[0]->getMonthly() - ($product[0]->getMonthly() / 100 * $product[0]->getMdiscount()) + $product[0]->getMsetup()), 2));
                break;
            case 3:
                $hostingItem->setPrice(number_format(($product[0]->getQuarterly() - ($product[0]->getQuarterly() / 100 * $product[0]->getQdiscount()) + $product[0]->getQsetup()), 2));
                break;
            case 6:
                $hostingItem->setPrice(number_format(($product[0]->getSemiannual() - ($product[0]->getSemiannual() / 100 * $product[0]->getSdiscount()) + $product[0]->getSsetup()), 2));
                break;
            case 12:
                $hostingItem->setPrice(number_format(($product[0]->getAnnual() - ($product[0]->getAnnual() / 100 * $product[0]->getAdiscount()) + $product[0]->getAsetup()), 2));
                break;
            default:
                $hostingItem->setPrice($product[0]->getPrice());
        }

        $hostingItem->setCreatedAt(new \Datetime());
        $hostingItem->setStatus(1);
        $hostingItem->setService(3);
        $hostingItem->setPackageId($product[0]->getId());
        $hostingItem->setPackageDomain($cart[0]->getDomain() . '.' . $cart[0]->getTld());
        $hostingItem->setPaymentPeriod($cart[0]->getBillingCycle());
        $hostingItem->setUserId($client[0]->getUserId());
        $hostingItem->setOrderId($clientOrder->getId());
        $hostingItem->setInvoiceId($unique_id);

        $em->persist($hostingItem);
        $em->flush();

        if ($cart[0]->getDomainMode() != 'owndomain') {
            $domainItem = new OrderItem();

            $domainItem->setCreatedAt(new \Datetime());
            $domainItem->setStatus(1);
            $domainItem->setPrice($domainPricing);
            $domainItem->setService(2);
            $domainItem->setPackageId(0);
            $domainItem->setPackageDomain(0);
            $domainItem->setOrderId($clientOrder->getId());
            $domainItem->setUserId($client[0]->getUserId());
            $domainItem->setInvoiceId($unique_id);
            $domainItem->setDetails($cart[0]->getDomain() . '.' . $cart[0]->getTld() . ', ' . $cart[0]->getTld());

            $em = $this->getDoctrine()->getManager();
            $em->persist($domainItem);
            $em->flush();
        }

        foreach ($items as $item) {

            if ($item['amount'] != 0) {
                $urlParams .= '&item_name_' . $i . '=' . $item['service'];
                $urlParams .= '&amount_' . $i . '=' . str_replace('$', '', number_format(($item['amount'] / 100 * $vat + $item['amount']), 2));

                $urlParams .= '&quantity_' . $i . '=' . 1;

                $i++;
            }
        }

        $url = $payment[0]->getUrl() . $urlParams;

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Cart');

        $cart = $repository->findBy(array('sessionId' => $sessionId));

        $em = $this->getDoctrine()->getManager();

        foreach ($cart as $cartEntry) {
            $em->remove($cartEntry);
            $em->flush();
        }

        if ($item['amount'] > 0) {
            return new RedirectResponse($url);
        } else {
            return new RedirectResponse('/order/thankyou/' . $unique_id);
        }

    }

    /**
     * @return RedirectResponse
     */
    public function paypalInvoiceAction($invoiceId) {

        $vat = (int)$this->forward('HostkitCoreBundle:Payment:vat')->getContent();
        $em = $this->getDoctrine()->getManager();

        $invoice = $this->getDoctrine()->getRepository('HostkitCoreBundle:Invoice')->find($invoiceId);

        $amount = number_format($invoice->getAmount(), 2);

        $unique_id = uniqid();

        $invoice->setInvoiceId($unique_id);

        $em->persist($invoice);
        $em->flush();

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Payment');

        $payment = $repository->findBy(array('provider' => 'paypal'));

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings');

        $settings = $repository->findBy(array('id' => 1));

        //Generate Paypal URL
        $urlParams = "?notify_url=/paypal/notify/invoice";
        $urlParams .= "&upload=1";
        $urlParams .= "&charset=utf-8";
        $urlParams .= "&currency_code=" . $payment[0]->getCurrencyCode();
        $urlParams .= "&business=" . $payment[0]->getEmail();
        $urlParams .= "&return_url=" . $payment[0]->getReturnUrl();
        $urlParams .= "&cmd=_cart";
        $urlParams .= "&invoice=" . $unique_id;


        if ($amount != 0) {
            $urlParams .= '&item_name_1=Inoivce' . $invoice->getId();
            $urlParams .= '&amount_1=' . $amount;

            $urlParams .= '&quantity_1=1';
        }

        $url = $payment[0]->getUrl() . $urlParams;


        if ($amount > 0) {
            return new RedirectResponse($url);
        } else {
            return new RedirectResponse('/order/thankyou/' . $unique_id);
        }

    }

    /**
     * @return Response
     */
    public function paypalNotifyInvoiceAction() {
        $logger = $this->get('logger');
        $em = $this->getDoctrine()->getManager();

        try {

            if (empty($_POST)) {
                throw new \Exception('Empty Response from Paypal.');
            }

            // Create an instance of the paypal library
            $paypal = new Paypal();

            // Log the IPN results
            $paypal->ipnLog = TRUE;

            //save post params from paypal to db
            $paymentTransaction = new PaymentTransaction();

            $paymentTransaction->setProvider(1);
            $paymentTransaction->setInvoice($_POST['invoice']);
            $paymentTransaction->setResidenceCountry($_POST['residence_country']);
            $paymentTransaction->setPaymentDate($_POST['payment_date']);
            $paymentTransaction->setTax($_POST['tax']);
            $paymentTransaction->setVerifySign($_POST['verify_sign']);
            $paymentTransaction->setPayerEmail($_POST['payer_email']);
            $paymentTransaction->setTxnType($_POST['txn_type']);
            $paymentTransaction->setPayerStatus($_POST['payer_status']);
            $paymentTransaction->setMcCurrency($_POST['mc_currency']);
            $paymentTransaction->setPaymentType($_POST['payment_type']);
            $paymentTransaction->setPaymentStatus($_POST['payment_status']);
            $paymentTransaction->setAddressStatus($_POST['address_status']);


            $em->persist($paymentTransaction);
            $em->flush();

            if ($_POST['payment_status'] == 'Completed') {
                $invoice = $this->getDoctrine()->getRepository('HostkitCoreBundle:Invoice')->findBy(array('invoice_id' => $_POST['invoice']));

                $invoice = $invoice[0];

                $date = new \DateTime('now');

                $invoice->setPaymentDate($date->format('d-m-Y H:i'));
                $invoice->setStatus(2);

                $em->persist($invoice);
                $em->flush();
            }

        } catch (\Exception $e) {
            $logger->error(__File__ . '::' . $e->getLine() . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . $e->getMessage());
        }

        return new Response('paypal invoice');
    }

    /**
     * @return Response
     */
    public function paypalNotifyAction() {

        $logger = $this->get('logger');
        $client = '';

        try {

            if (empty($_POST)) {
                throw new \Exception('Empty Response from Paypal.');
            }

            // Create an instance of the paypal library
            $paypal = new Paypal();

            // Log the IPN results
            $paypal->ipnLog = TRUE;

            //save post params from paypal to db
            $paymentTransaction = new PaymentTransaction();

            $paymentTransaction->setProvider(1);
            $paymentTransaction->setInvoice($_POST['invoice']);
            $paymentTransaction->setResidenceCountry($_POST['residence_country']);
            $paymentTransaction->setPaymentDate($_POST['payment_date']);
            $paymentTransaction->setTax($_POST['tax']);
            $paymentTransaction->setVerifySign($_POST['verify_sign']);
            $paymentTransaction->setPayerEmail($_POST['payer_email']);
            $paymentTransaction->setTxnType($_POST['txn_type']);
            $paymentTransaction->setPayerStatus($_POST['payer_status']);
            $paymentTransaction->setMcCurrency($_POST['mc_currency']);
            $paymentTransaction->setPaymentType($_POST['payment_type']);
            $paymentTransaction->setPaymentStatus($_POST['payment_status']);
            $paymentTransaction->setAddressStatus($_POST['address_status']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($paymentTransaction);
            $em->flush();

            if ($_POST['payment_status'] == 'Completed') {

                $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order');

                $order = $repository->findBy(array('invoice_id' => $_POST['invoice']));

                if (!is_object($order[0])) {
                    throw new \Exception('Invoice ID didnt matched any existing one in DB. ID:' . $_POST['invoice']);
                } else {
                    $order[0]->setStatus(2);
                    $em->persist($order[0]);
                    $em->flush();
                }

                $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings');

                $settings = $repository->find(1);

                if ($settings->getAutoJobsDomains() == 1 || $settings->getAutoJobsHosting() == 1) {

                    $domains = array();

                    $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order');
                    $clientOrder = $repository->findBy(array('invoice_id' => $_POST['invoice']));

                    $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
                    $client = $repository->findBy(array('id' => $clientOrder[0]->getUserId()));

                    $client[0]->setStatusId(2);
                    $em->persist($client[0]);
                    $em->flush();

                    $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:OrderItem');
                    $clientOrderItemsDomains = $repository->findBy(array('order_id' => $clientOrder[0]->getId(), 'service' => 2));
                    $clientOrderItemsHosting = $repository->findBy(array('order_id' => $clientOrder[0]->getId(), 'service' => 3));

                    //auto job domains
                    if ($settings->getAutoJobsDomains() == 1 && is_object($clientOrderItemsDomains[0])) {

                        foreach ($clientOrderItemsDomains as $clientOrderItemsDomain) {
                            $domains[] = $clientOrderItemsDomain;

                            $clientOrderItemsDomain->setStatus(3);
                            $em->persist($clientOrderItemsDomain);
                            $em->flush();
                        }

                        foreach ($domains as $domain) {
                            $domain = explode(',', $domain->getDetails());

                            $result = $this->get("domain.management.service")->register($domain[0], $client[0]->getId());


                            $this->forward('HostkitEmailBundle:Default:send', array(
                                'name'     => 'domain_register_successfull',
                                'clientId' => $client[0]->getId(),
                                'params'   => array('domain' => $domain[0])
                            ));

                        }
                    } else if ($settings->getAutoJobsDomains() == 1) {
                        throw new \Exception('Could not register domain.');
                    }

                    if ($settings->getAutoJobsHosting() == 1 && !empty($clientOrderItemsHosting)) {

                        $hosting = array();

                        foreach ($clientOrderItemsHosting as $hostingPackage) {
                            $hosting[] = $hostingPackage;

                            $hostingPackage->setStatus(3);
                            $em->persist($hostingPackage);
                            $em->flush();
                        }

                        foreach ($hosting as $account) {

                            $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Product');
                            $product = $repository->findBy(array('id' => $account->getPackageId()));

                            $pkgname = $product[0]->getCpanelPackage();
                            $domain = $account->getPackageDomain();
                            $password = $this->get("account.service")->generateRandomPassword();
                            $username = substr(str_replace('.', '', $domain), 0, 8);

                            $cpanelApi = $this->get("hosting.management.service")->getCpanelApi();
                            $ipAddress = $this->get("hosting.management.service")->getIpAddress();

                            $accountDetails = $cpanelApi->createacct(array(
                                'username'     => $username,
                                'password'     => $password,
                                'domain'       => $domain,
                                'plan'         => $pkgname,
                                'contactemail' => $client[0]->getEmail()
                            ));

                            $rawMessage = $accountDetails->result->rawout;


                            $this->forward('HostkitEmailBundle:Default:send', array(
                                'name'     => 'new_hosting_account',
                                'clientId' => $client[0]->getId(),
                                'params'   => array('username' => $username, 'domain' => $domain, 'package' => $pkgname, 'password' => $password, 'server_ip' => $ipAddress)
                            ));


                            if ($accountDetails->result->status == 0) {
                                throw new \Exception('Couldnt create account for domain: ' . $domain . ' cpanel errormsg: ' . (string)$accountDetails->result->statusmsg);
                            }

                        }

                    }


                } else {
                    $this->forward('HostkitEmailBundle:Default:send', array(
                        'name'     => 'admin_new_order',
                        'clientId' => $client->getId()
                    ));
                }
            }
        } catch (\Exception $e) {
            $logger->error(__File__ . '::' . $e->getLine() . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . $e->getMessage());
        }

        return new Response('paypal');
    }

    /**
     * @return Response
     */
    public function paypalReturnAction() {

        return new Response('');
    }
}