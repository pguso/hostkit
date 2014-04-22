<?php

namespace Hostkit\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;
use Hostkit\ClientBundle\Form\Type\EmailType,
    Hostkit\ClientBundle\Form\Type\EmailForwardType;

/**
 * Class DomainHostingController
 * @package Hostkit\ClientBundle\Controller
 */
class DomainHostingController extends Controller {

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function subdomainsAction(Request $request) {
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->listpopswithdisk();
        $subdomains = $hosting_service->listsubdomains();
        $domain = $hosting_service->getDomainName();
        $error = '';

        $form = $this->createForm(new EmailForwardType());

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $email = $form->getData();
                $mail = $email['email'];
                $fwdemail = $email['forward'];

                $add_forward = $hosting_service->addforward($mail, $fwdemail);

                return $this->redirect($this->generateUrl('hostkit_client_email_forwarders'));
            } else {
                $error = 'Es ist ein Fehler aufgetreten bei der Verarbeitung des Formulars. Bitte wenden Sie sich an den Systemadministrator.';
            }
        }

        return $this->render('HostkitClientBundle:HostingDomains:subdomains.html.twig', array(
            'emails' => $emails,
            'subdomains' => $subdomains,
            'form' => $form->createView(),
            'domain' => $domain,
            'error' => $error,
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function addondomainsAction(Request $request) {
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->listpopswithdisk();
        $addondomains = $hosting_service->listaddondomains();
        $domain = $hosting_service->getDomainName();
        $error = '';

        $form = $this->createForm(new EmailForwardType());

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $email = $form->getData();
                $mail = $email['email'];
                $fwdemail = $email['forward'];

                $add_forward = $hosting_service->addforward($mail, $fwdemail);

                return $this->redirect($this->generateUrl('hostkit_client_email_forwarders'));
            } else {
                $error = 'Es ist ein Fehler aufgetreten bei der Verarbeitung des Formulars. Bitte wenden Sie sich an den Systemadministrator.';
            }
        }

        return $this->render('HostkitClientBundle:HostingDomains:addondomains.html.twig', array(
            'emails' => $emails,
            'addondomains' => $addondomains,
            'form' => $form->createView(),
            'domain' => $domain,
            'error' => $error,
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function redirectsAction(Request $request) {
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->listpopswithdisk();
        $redirects = $hosting_service->listredirects();
        $domain = $hosting_service->getDomainName();
        $error = '';

        $form = $this->createForm(new EmailForwardType());

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $email = $form->getData();
                $mail = $email['email'];
                $fwdemail = $email['forward'];

                $add_forward = $hosting_service->addforward($mail, $fwdemail);

                return $this->redirect($this->generateUrl('hostkit_client_email_forwarders'));
            } else {
                $error = 'Es ist ein Fehler aufgetreten bei der Verarbeitung des Formulars. Bitte wenden Sie sich an den Systemadministrator.';
            }
        }

        return $this->render('HostkitClientBundle:HostingDomains:redirects.html.twig', array(
            'emails' => $emails,
            'redirects' => $redirects,
            'form' => $form->createView(),
            'domain' => $domain,
            'error' => $error,
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function dnsAction(Request $request) {
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->listpopswithdisk();
        $dnss = $hosting_service->listzones();
        $domain = $hosting_service->getDomainName();
        $error = '';

        $form = $this->createForm(new EmailForwardType());

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $email = $form->getData();
                $mail = $email['email'];
                $fwdemail = $email['forward'];

                $add_forward = $hosting_service->addforward($mail, $fwdemail);

                return $this->redirect($this->generateUrl('hostkit_client_email_forwarders'));
            } else {
                $error = 'Es ist ein Fehler aufgetreten bei der Verarbeitung des Formulars. Bitte wenden Sie sich an den Systemadministrator.';
            }
        }

        return $this->render('HostkitClientBundle:HostingDomains:dns.html.twig', array(
            'emails' => $emails,
            'dnss' => $dnss,
            'form' => $form->createView(),
            'domain' => $domain,
            'error' => $error,
        ));
    }

}
