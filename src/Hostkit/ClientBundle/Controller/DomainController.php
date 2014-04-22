<?php

namespace Hostkit\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;
use Hostkit\ClientBundle\Form\Type\EmailType,
    Hostkit\ClientBundle\Form\Type\IpType,
	Hostkit\ClientBundle\Form\Type\SubdomainType,
    Hostkit\ClientBundle\Form\Type\NameserverType,
    Hostkit\ClientBundle\Form\Type\EmailAccountType,
    Hostkit\ClientBundle\Form\Type\DomainForwardType,
    Hostkit\ClientBundle\Form\Type\EmailForwardType;

/**
 * Class DomainController
 * @package Hostkit\ClientBundle\Controller
 */
class DomainController extends Controller {

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function overviewAction() {

        $userId = $this->getUser()->getId();

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');
			
		$settings = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings')->find(1);

        $activeItems = $repository->findBy(array('user_id' => $userId, 'service' => 2));

        foreach ($activeItems as $activeItem) {
            $activeItem->setCreatedAt($activeItem->getCreatedAt()->format('Y-m-d'));
            $details = explode(',', $activeItem->getDetails());
            $activeItem->setDetails($details[0]);
			
			$order = $this->container->get('domain.management.service')->getOrderId($details[0]);

			if(!is_int($order)) {
				if(property_exists($order, 'status')) {
					$activeItem->setStatus(2);
				}
			}
			
        }

		

        return $this->render('HostkitClientBundle:Domain:index.html.twig', array(
            'activeItems' => $activeItems,
			'settings' => $settings
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function configAction($domainId) {


        return $this->render('HostkitClientBundle:Domain:config.html.twig', array(
            'domainId' => $domainId
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function viewMailAction($domainId) {

        $domain = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem')->find($domainId);

        $domain = explode(',', $domain->getDetails());
        $domain = $domain[0];

        $accounts = $this->get("domain.management.service")->searchEmail($domain, '');

        return $this->render('HostkitClientBundle:Domain:view-mail.html.twig', array(
            'mailAccounts' => $accounts,
            'domainId'     => $domainId,
            'domain'       => $domain
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function viewMailForwardAction($domainId) {

        $domain = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem')->find($domainId);

        $domain = explode(',', $domain->getDetails());
        $domain = $domain[0];

        $accounts = $this->get("domain.management.service")->searchEmail($domain, 'forward_only');

        return $this->render('HostkitClientBundle:Domain:view-mail-forward.html.twig', array(
            'mailAccounts' => $accounts,
            'domainId'     => $domainId,
            'domain'       => $domain
        ));
    }
	
	/**
     *
     * @return mixed
     */
    public function viewSubdomainsAction($domainId) {

        $domain = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem')->find($domainId);

        $domain = explode(',', $domain->getDetails());
        $domain = $domain[0];

        $subdomains = $this->get("domain.management.service")->dnsDetails($domain, 'A');
		
		$noSub = array('@', 'www');
		
		foreach($subdomains as $index => $subdomain) {
			foreach($noSub as $value) {
				$key = array_search($value, (array) $subdomain);
				
				if($key) {
					unset($subdomains[$index]);
				}
			}
		}

        return $this->render('HostkitClientBundle:Domain:view-subdomains.html.twig', array(
            'subdomains' => $subdomains,
            'domainId'     => $domainId,
            'domain'       => $domain
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function viewDomainForwardAction($domainId) {

        $domain = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem')->find($domainId);

        $domain = explode(',', $domain->getDetails());
        $domain = $domain[0];

        $forwardDomain = $this->get("domain.management.service")->detailsDomainForward($domain);

        return $this->render('HostkitClientBundle:Domain:view-domain-forward.html.twig', array(
            'forwardDomain' => $forwardDomain,
            'domainId'      => $domainId,
            'domain'        => $domain
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function addMailAction(Request $request, $domainId) {

        $message = '';

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');

        $domain = $repository->find($domainId);
        $domainDetails = explode(',', $domain->getDetails());

        $settings = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings')->find(1);


        $form = $this->createForm(new EmailAccountType(), array(), array('data' => array('domain' => $domainDetails[0])));

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();

                $response = $this->get("domain.management.service")->addMailAccount($domainDetails[0], array(
                    'email'        => $requestData['email_account']['name'],
                    'passwd'       => 'jerry007',
                    'notification' => $settings->getCompanyEmail(),
                    'firstname'    => 'pat',
                    'lastname'     => 'guso'
                ));

                if (property_exists($response->response, 'message')) {
                    $message = $response->response->message;
                } else {
                    $message = 'Successfully added email account.';
                }
            }
        }

        return $this->render('HostkitClientBundle:Domain:add-mail.html.twig', array(
            'form'     => $form->createView(),
            'domainId' => $domainId,
            'message'  => $message
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function addMailForwardAction(Request $request, $domainId) {

        $message = '';

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');

        $domain = $repository->find($domainId);
        $domainDetails = explode(',', $domain->getDetails());

        $settings = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings')->find(1);


        $form = $this->createForm(new EmailForwardType(), array(), array('data' => array('domain' => $domainDetails[0])));

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();

                $response = $this->get("domain.management.service")->addMailForward($domainDetails[0], array(
                    'email'   => $requestData['email_forward']['name'],
                    'forward' => $requestData['email_forward']['forward']
                ));

                if (property_exists($response->response, 'message')) {
                    $message = $response->response->message;
                } else {
                    $message = 'Successfully added forwarding.';
                }
            }
        }

        return $this->render('HostkitClientBundle:Domain:add-mail-forward.html.twig', array(
            'form'     => $form->createView(),
            'domainId' => $domainId,
            'message'  => $message
        ));
    }
	
	/**
     * @param Request $request
     *
     * @return mixed
     */
    public function addSubdomainAction(Request $request, $domainId) {

        $message = '';

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');

        $domain = $repository->find($domainId);
        $domainDetails = explode(',', $domain->getDetails());

        $settings = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings')->find(1);


        $form = $this->createForm(new SubdomainType(), array(), array('data' => array('domain' => $domainDetails[0])));

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();

                $response = $this->get("domain.management.service")->addIp4($domainDetails[0], array(
                    'host'   => $requestData['subdomain']['subdomain'],
                    'value' => $requestData['subdomain']['ip']
                ));

                $message = $response->msg;
            }
        }

        return $this->render('HostkitClientBundle:Domain:add-subdomain.html.twig', array(
            'form'     => $form->createView(),
            'domainId' => $domainId,
            'message'  => $message
        ));
    }
	
	/**
     * @param Request $request
     *
     * @return mixed
     */
    public function modifySubdomainAction(Request $request, $domainId, $sub) {

        $message = '';
		$ip = '';

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');

        $domain = $repository->find($domainId);
        $domainDetails = explode(',', $domain->getDetails());

        $settings = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings')->find(1);

		$dnsRecords = $this->get("domain.management.service")->dnsDetails('gutersohn.biz', 'A', $sub);
		
		if(is_array($dnsRecords)) {
			$ip = $dnsRecords[0]->value;
		}
		
        $form = $this->createForm(new SubdomainType(), array(), array('data' => array('domain' => $domainDetails[0], 'ip' => $ip, 'sub' => $sub)));

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();

                $response = $this->get("domain.management.service")->modifyIp4($domainDetails[0], array(
                    'host'   => $requestData['subdomain']['subdomain'],
                    'new' => $requestData['subdomain']['ip'],
					'current' => $ip
                ));

                $message = $response->msg;
            }
        }

        return $this->render('HostkitClientBundle:Domain:add-subdomain.html.twig', array(
            'form'     => $form->createView(),
            'domainId' => $domainId,
            'message'  => $message,
			'modify' => 1,
			'domain' => $domainDetails[0]
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function addDomainForwardAction(Request $request, $domainId) {

        $message = '';

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');

        $domain = $repository->find($domainId);
        $domainDetails = explode(',', $domain->getDetails());

        $settings = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings')->find(1);


        $form = $this->createForm(new DomainForwardType());

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();

                $response = $this->get("domain.management.service")->addDomainForward($domainDetails[0], array(
                    'forward' => $requestData['domain_forward']['forward'],
                    'masking' => (array_key_exists('masking', $requestData['domain_forward']) ? true : ''),
                    'sub'     => (array_key_exists('sub', $requestData['domain_forward']) ? true : ''),
                    'path'    => (array_key_exists('path', $requestData['domain_forward']) ? true : '')
                ));

                if ($response->status == 'Success') {
                    $message = 'Successfully added forwarding.';
                } else {
                    $message = 'Couldnt add forwarding';
                }
            }
        }

        return $this->render('HostkitClientBundle:Domain:add-domain-forward.html.twig', array(
            'form'     => $form->createView(),
            'domainId' => $domainId,
            'message'  => $message
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function modifyNameserverAction(Request $request, $domainId) {

        $message = '';

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');

        $domain = $repository->find($domainId);
        $domainDetails = explode(',', $domain->getDetails());

        $settings = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings')->find(1);

        $nsDetails = $this->get("domain.management.service")->dnsDetails($domainDetails[0], 'NS');

        $form = $this->createForm(new NameserverType(), array(), array('data' => array('ns' => $nsDetails)));

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();
                unset($requestData['ns']['_token']);
                $count = 3;
                $nsCount = 1;

                foreach ($requestData['ns'] as $ns) {

                    if ($ns != $nsDetails[$count]->value) {
                        if ($this->inArray($nsDetails, 'ns' . $nsCount)) {
                            $response = $this->get("domain.management.service")->modifyNameserver($domainDetails[0], array(
                                'host'    => 'ns' . $nsCount,
                                'current' => $nsDetails[$count]->value,
                                'new'     => $ns
                            ));
                        } else {
                            $response = $this->get("domain.management.service")->addNameserver($domainDetails[0], array(
                                'host'    => 'ns' . $nsCount,
                                'current' => $nsDetails[$count]->value,
                                'new'     => $ns
                            ));
                        }
                    }

                    $count--;
                    $nsCount++;
                }

                if (property_exists($response, 'msg')) {
                    $message = $response->msg;
                } else {
                    $message = 'Could not update record.';
                }
            }
        }

        return $this->render('HostkitClientBundle:Domain:add-nameserver.html.twig', array(
            'form'     => $form->createView(),
            'domainId' => $domainId,
            'message'  => $message
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function addIpsAction(Request $request, $domainId) {

        $message = '';
        $ipValue = '';

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');

        $domain = $repository->find($domainId);
        $domainDetails = explode(',', $domain->getDetails());

        $settings = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Settings')->find(1);

        $ipDetails = $this->get("domain.management.service")->dnsDetails($domainDetails[0], 'A');

        if (array_key_exists(0, $ipDetails)) {
            $ipValue = $ipDetails[0]->value;
        }

        $form = $this->createForm(new IpType(), array('ipValue' => $ipValue));

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();

                if (empty($ipDetails)) {
                    $response = $this->get("domain.management.service")->addIp4($domainDetails[0], array(
                        'value' => $requestData['ip']['value']
                    ));
                } else {
                    $response = $this->get("domain.management.service")->modifyIp4($domainDetails[0], array(
                        'new'     => $requestData['ip']['value'],
                        'current' => $ipValue
                    ));
                }

                if ($response->status == 'ERROR') {
                    $message = $response->message;
                } else {
                    $message = 'Updated Records';
                }
            }
        }

        return $this->render('HostkitClientBundle:Domain:add-ip.html.twig', array(
            'form'     => $form->createView(),
            'domainId' => $domainId,
            'message'  => $message
        ));
    }

    private function inArray($multiArray, $stack) {
        foreach ($multiArray as $array) {
            $found = in_array($stack, (array)$array);

            if ($found) {
                return true;
            }
        }

        return false;
    }

    public function webspaceAction($domainId) {

        $orderItem = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem')->find($domainId);

        $orderItem = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem')->findBy(array('user_id' => $orderItem->getUserId(), 'service' => 3));


        return $this->redirect($this->generateUrl('hostkit_client_hosting_config', array('packageId' => $orderItem[0]->getPackageId())));
    }

}
