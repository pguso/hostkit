<?php

namespace Hostkit\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response;

/**
 * Class DomainController
 * @package Hostkit\CoreBundle\Controller
 */
class DomainController extends Controller
{
    /**
     * @param $name
     *
     * @return mixed
     */
    public function indexAction()
    {


        $result = '';

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
        $client = $repository->findBy(array('id' => 65));

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order');
        $clientOrder = $repository->findBy(array('user_id' => $client[0]->getId()));

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:OrderItem');
        $clientOrderItemsDomains = $repository->findBy(array('order_id' => $clientOrder[0]->getId(), 'service' => 2));
        $clientOrderItemsHosting = $repository->findBy(array('order_id' => $clientOrder[0]->getId(), 'service' => 3));
////////////
        foreach ($clientOrderItemsDomains as $clientOrderItemsDomain) {
            $domains[] = $clientOrderItemsDomain;
        }

        $hosting = array();

        foreach ($clientOrderItemsHosting as $hostingPackage) {
            $hosting[] = $hostingPackage;
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
                'username' => $username,
                'password' => $password,
                'domain' => $domain,
                'plan' => $pkgname,
                'contactemail' => $client[0]->getEmail()
            ));

            $rawMessage = $accountDetails->result->rawout;

            if($accountDetails->result->status == 1) {
            $result = $this->forward('HostkitEmailBundle:Default:send', array(
                            'name'  => 'new_hosting_account',
                            'clientId' => $client[0]->getId(),
                            'params' => array('username' => $username, 'domain' => $domain, 'package' => $pkgname, 'password' => $password, 'server_ip' => $ipAddress)
                        ));
            }

        }

        if(true) {
        foreach ($domains as $domain) {
            $domain = explode(',', $domain->getDetails());

            $result = $this->get("domain.management.service")->register($domain[0], $client[0]->getId());

        }
    }



        return new Response($result);
    }

    public function domainTestAction() {
        //$result = $this->get("domain.management.service")->register('fshbd.de', 61);
		//$result = $this->get("domain.management.service")->domainForwarding('gutersohn.biz', array('forward' => 'cms.gutersohn.biz', 'sub' => true));
		//addIp4
		$result = $this->get("domain.management.service")->dnsDetails('gutersohn.biz', 'A');

        var_dump($result);die();
    }

    /**
     * @return Response
     */
    public function checkDomainAvailabilityAction()
    {

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

        if (is_object($domain_price[0])) {
            $price = '$' . $domain_price[0]->getPrice();

            $response = array('resultcode' => $this->get("domain.management.service")->domainAvailability($domain, $tld), 'domain' => $domain . '.' . $tld, 'price' => $price);
        } else {
            $response = array('resultcode' => 200, 'domain' => $domain . '.' . $tld);
        }


        return new Response(json_encode($response));
    }
}
