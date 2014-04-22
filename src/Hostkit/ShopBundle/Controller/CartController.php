<?php

namespace Hostkit\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\JsonResponse,
    Symfony\Component\HttpFoundation\Session\Session,
    Hostkit\CoreBundle\Entity\Cart,
	Hostkit\CoreBundle\Entity\Client,
	Hostkit\UserBundle\Entity\User,
    Symfony\Component\Form\FormError,
	Hostkit\ShopBundle\Form\Type\CheckoutType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class CartController
 * @package Hostkit\ShopBundle\Controller
 */
class CartController extends Controller {
	/**
	 * @return mixed
	 */
	public function indexAction() {
        $package_ids = '1';

        return $this->render('HostkitShopBundle:Default:index.html.twig', array(
            'package_ids' => $package_ids,
        ));
    }

    //Shoppind Cart - Step 1 - Choose Domain
	/**
	 * @param $package_id
	 *
	 * @return mixed
	 */
	public function stepOneAction($package_id) {
        $session = $this->get('session');
        $sessionId = $session->getId();
        $quantity = 0;

        $em = $this->getDoctrine()->getManager();
        $sites = $em->getRepository('HostkitCoreBundle:Site')->findAll();

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:DomainPricing');

        $domains = $repository->findAll();

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Cart');

        $cart = $repository->findBy(array('sessionId' => $sessionId));

        //TODO: make it possible to buy more than one package at once
        if(!empty($cart)) {
            $cart[0]->setProductId($package_id);
            $cart[0]->setCreatedAt(new \DateTime('now'));
            $cart[0]->setSessionId($sessionId);
            $cart = $cart[0];
        } else {
            $cart = new Cart();

            $cart->setProductId($package_id);
            $cart->setCreatedAt(new \DateTime('now'));
            $cart->setSessionId($sessionId);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($cart);
        $em->flush();

        return $this->render('HostkitShopBundle:Cart:step_1_domain.html.twig', array(
                'domains' => $domains,
                'sites' => $sites
            )
        );
    }

    //Shoppind Cart - Step 2 - Select Package and add personal infos
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function stepTwoAction(Request $request) {
        $title = 'Personal Informations';

        $error = '';
		
		$session = $this->get('session');
		$sessionId = $session->getId();

        $em = $this->getDoctrine()->getManager();
        $sites = $em->getRepository('HostkitCoreBundle:Site')->findAll();
		
		$repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Cart');

        $cart = $repository->findBy(array('sessionId' => $sessionId));

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings');

        $settings = $repository->findBy(array('id' => 1));

		$id = $cart[0]->getProductId();
		
		$repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Product');

        $product = $repository->findBy(array('id' => $id));

		$client = new Client();
		//TODO:get discount and show it via data attribute in choice field
        $form = $this->createForm(new CheckoutType($this->getDoctrine()->getManager()), $client, array('data' => array('productId' => $id, 'product' => $product)));
		
        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();//$requestData['client']['package'], $requestData['client']['billing_cycle']
				$agb = $requestData['client']['agb'];
				
				if($agb !== 0) {
				
					$client->setStatusId(1);
					$client->setFirstname($requestData['client']['firstname']);
					$client->setLastname($requestData['client']['lastname']);
					$client->setPhone($requestData['client']['phone']);
					$client->setEmail($requestData['client']['email']);
					$client->setAddress1($requestData['client']['address1']);
					$client->setPostcode($requestData['client']['postcode']);
					$client->setCity($requestData['client']['city']);
					$client->setCountry($requestData['client']['country']);
					$client->setState($requestData['client']['state']);
					$client->setPassword($requestData['client']['password']);

					$em = $this->getDoctrine()->getManager();
					$em->persist($client);
					$em->flush();
					
					$session = $this->get('session');
					$sessionId = $session->getId();
					
					$repository = $this->getDoctrine()
						->getRepository('HostkitCoreBundle:Cart');

					$cart = $repository->findBy(array('sessionId' => $sessionId));

                    if(isset($requestData['client']['billing_cycle'])) {
                        $cart[0]->setBillingCycle($requestData['client']['billing_cycle']);
                    }

					$cart[0]->setProductId($product[0]->getId());
					$cart[0]->setClientId($client->getId());
					
					$em->persist($cart[0]);
					$em->flush();

					$userManager = $this->container->get('fos_user.user_manager');

					try {
					    $userAdmin = $userManager->createUser();

					    $userAdmin->setUsername($requestData['client']['email']);
					    $userAdmin->setEmail($requestData['client']['email']);
					    $userAdmin->setPlainPassword($requestData['client']['password']);
					    $userAdmin->setRoles(array('ROLE_CLIENT'));
					    $userAdmin->setRegisterDate(date('d-m-Y H:i'));
					    $userAdmin->setEnabled(true);

					    $userManager->updateUser($userAdmin, true);
						
						$client->setUserId($userAdmin->getId());
						$em->persist($client);
						$em->flush();
						
	                } catch (\Doctrine\DBAL\DBALException $e) {

	                    if (is_int(strpos($e->getPrevious()->getMessage(), 'Duplicate entry'))) {
	                        $error = 'This E-Mail Address allready exists in our Database. Please Login or change E-Mail Address to place your order.';
	                    } else {
	                        $error = $e->getPrevious()->getMessage();
	                    }
	                }

					if(is_int($userAdmin->getId()) && empty($error)) {
					    $res = $this->forward('HostkitEmailBundle:Default:send', array(
					        'name'  => 'signup',
					        'clientId' => $client->getId(),
                            'params' => array('username' => $userAdmin->getUsername(), 'password' => $requestData['client']['password'])

					    ));

					    return $this->redirect($this->generateUrl('hostkit_shop_cart_three'));
					}

				} else {
					$form->addError(new FormError('Please accept the terms and conditions!'));
				}
			}
		}

        return $this->render('HostkitShopBundle:Cart:step_2_contact.html.twig', array(
			'form' => $form->createView(),
			'settings' => $settings[0],
            'sites' => $sites,
            'error' => $error
        ));
    }
	
	//Shoppind Cart - Step 3 - Review Order
    public function stepThreeAction() {
        $domainPricing = 0;
		$session = $this->get('session');
		$sessionId = $session->getId();

        $em = $this->getDoctrine()->getManager();
        $sites = $em->getRepository('HostkitCoreBundle:Site')->findAll();

		$repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Cart');

        $cart = $repository->findBy(array('sessionId' => $sessionId));
		
		$repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Client');

        $client = $repository->findBy(array('id' => $cart[0]->getClientId()));
		
		$repository = $this->getDoctrine()
			->getRepository('HostkitCoreBundle:Product');

		$product = $repository->findBy(array('id' => $cart[0]->getProductId()));

        if($product[0]->getTypeId() == 3) {
            $product[0]->setPrice(number_format(0.00, 2));
        }

		if($cart[0]->getTld() != '' && $cart[0]->getDomainMode() != 'owndomain') {
            $repository = $this->getDoctrine()
                ->getRepository('HostkitCoreBundle:DomainPricing');

            $domainPricing = $repository->findBy(array('tld' => $cart[0]->getTld()));
        }

			switch($cart[0]->getBillingCycle()) {
				case 1:
					$product[0]->setPrice(number_format(($product[0]->getMonthly() - ($product[0]->getMonthly() / 100 * $product[0]->getMdiscount()) + $product[0]->getMsetup()), 2));
					break;
				case 3:
					$product[0]->setPrice(number_format(($product[0]->getQuarterly() - ($product[0]->getQuarterly() / 100 * $product[0]->getQdiscount())  + $product[0]->getQsetup()), 2));
					break;
				case 6:
					$product[0]->setPrice(number_format(($product[0]->getSemiannual() - ($product[0]->getSemiannual() / 100 * $product[0]->getSdiscount())  + $product[0]->getSsetup()), 2));
					break;
				case 12:
					$product[0]->setPrice(number_format(($product[0]->getAnnual() - ($product[0]->getAnnual() / 100 * $product[0]->getAdiscount())  + $product[0]->getAsetup()), 2));
					break;
        }

		return $this->render('HostkitShopBundle:Cart:step_3_review.html.twig', array(
			'client' => $client[0],
			'cart' => $cart[0],
			'product' => $product[0],
			'domainPricing' => $domainPricing[0],
            'sites' => $sites
        ));
	}

	/**
	 * @return JsonResponse
	 */
	public function checkDomainAvailabilityAction() {

        if (isset($_POST['domain'])) {
            $domain = $_POST['domain'] . '.' . $_POST['tld'];
        } else if (isset($_POST['domainname'])) {
            $domain = $_POST['domainname'] . '.' . $_POST['tld'];
        }

        $domain_service = $this->container->get('domain.management.service');
        $domainResponse = array('resultcode' => $domain_service->domainAvailability($domain));

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:DomainPricing');

        $domainPrice = $repository->findBy(array('tld' => $_POST['tld']));

        $request = $this->getRequest();
        $locale = $request->getLocale();

        if ($locale == 'de') {
            $domainPrice = array('price' => $domainPrice[0]->getPriceEuro() . ' €');
        } else {
            $domainPrice = array('price' => '$ ' . $domainPrice[0]->getPriceUsd());
        }

        $domainResponse = array_merge($domainPrice, $domainResponse);

        $response = new JsonResponse();
        $response->setData($domainResponse);

        return $response;
    }

	/**
	 * @return Response
	 */
	public function sessionDataAction() {
		$session = $this->get('session');
		$sessionId = $session->getId();
		
		$repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Cart');

        $cart = $repository->findBy(array('sessionId' => $sessionId));
		
		if(isset($_POST['tld'])) {
				$cart[0]->setDomain($_POST['domainname']);
				$cart[0]->setTld($_POST['tld']);
				$cart[0]->setDomainMode($_POST['mode']);
				
				$em = $this->getDoctrine()->getManager();
				$em->persist($cart[0]);
				$em->flush();
				
				return new Response(100);
		} else {
			$cart = new Cart();
			
			$domain = explode('.', $_POST['domainname']);
			
			$cart->setSessionId($sessionId);
			$cart->setDomain($domain[0]);
			$cart[0]->setDomainMode($_POST['mode']);
			$cart->setProductId(0);
			$cart->setTld($domain[1]);
			$cart->setCreatedAt(new \DateTime('now'));
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($cart);
			$em->flush();
		
			return new Response(200);
		}		
	}

    /**
     * @return mixed
     */
    public function getPackageAction($packageId) {

        $package = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Product')->findBy(array('id' => $packageId));

        return new JsonResponse();
    }

    public function thankyouAction($invoiceId) {
        $em = $this->getDoctrine()->getManager();
        $client = '';

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order');

        $order = $repository->findBy(array('invoice_id' => $invoiceId));

        if (!is_object($order[0])) {
            throw new \Exception('Invoice ID didnt matched any existing one in DB. ID:' . $invoiceId);
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
            $clientOrder = $repository->findBy(array('invoice_id' => $invoiceId));

            $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
            $client = $repository->findBy(array('id' => $clientOrder[0]->getUserId()));

            $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:OrderItem');
            $clientOrderItemsDomains = $repository->findBy(array('order_id' => $clientOrder[0]->getId(), 'service' => 2));
            $clientOrderItemsHosting = $repository->findBy(array('order_id' => $clientOrder[0]->getId(), 'service' => 3));

            //auto job domains
            if ($settings->getAutoJobsDomains() == 1 && !empty($clientOrderItemsDomains)) {

                foreach ($clientOrderItemsDomains as $clientOrderItemsDomain) {
                    $domains[] = $clientOrderItemsDomain;
                }

                foreach ($domains as $domain) {
                    $domain = explode(',', $domain->getDetails());

                    $this->get("domain.management.service")->registerDomain($domain[0], $domain[1], $client[0]);

                }
            }

            if ($settings->getAutoJobsHosting() == 1 && !empty($clientOrderItemsHosting)) {

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

                    if((string)$accountDetails->result->status == 1) {
                        $result = $this->forward('HostkitEmailBundle:Default:send', array(
                            'name'  => 'new_hosting_account',
                            'clientId' => $client[0]->getId(),
                            'params' => array('username' => $username, 'domain' => $domain, 'package' => $pkgname, 'password' => $password, 'server_ip' => $ipAddress)
                        ));
                    }

                }

            }


        } else {
            $this->forward('HostkitEmailBundle:Default:send', array(
                'name' => 'admin_new_order',
                'clientId' => $client->getId()
            ));
        }
        return $this->render('HostkitShopBundle:Cart:thankyou.html.twig', array(
        ));
    }
	
}
