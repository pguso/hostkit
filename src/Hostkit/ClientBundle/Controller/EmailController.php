<?php

namespace Hostkit\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;
use Hostkit\ClientBundle\Form\Type\EmailType,
    Hostkit\ClientBundle\Form\Type\EmailForwardType;

/**
 * Class EmailController
 * @package Hostkit\ClientBundle\Controller
 */
class EmailController extends Controller {

	/**
	 * @return mixed
	 */
	public function addAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $hosting_service = $this->container->get('hosting.management.service');
        $this->hosting_service = $hosting_service;

        return $this->render('HostkitClientBundle:Hosting:index.html.twig', array(
                    'name' => ''
                ));
    }

	/**
	 * @param Request $request
	 * @param         $message
	 *
	 * @return int|string
	 */public function listAction(Request $request, $message) {
        $hosting_service = $this->container->get('hosting.management.service');

        /* TODO: send error to dashboard tpl */
        try {
        $emails = $hosting_service->listpopswithdisk(); 
        $domain = $hosting_service->getDomainName();
        } catch(\Exception $e) {
            $response = $this->forward('HostkitClientBundle:Default:dashboard', array(
                //'error'  => $error
            ));

            return $response;
        }

        $form = $this->createForm(new EmailType());

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $email = $form->getData();

                $mail = $email['email'];
                $quota = $email['quota'];
                $password = $email['password'];
                $proof = $email['proof'];

                if($proof == 'existing_email') {
                    $response = $hosting_service->changepop($mail, $password, $quota);

                    if(isset($response->data->reason) && !empty($response->data->reason)) {
                        $response = $response->data->reason;
                    } else {
                        $response = 0;
                    }
                } else {
                    $hosting_service->addpop($mail, $password, $quota);
                    $response = '';
                }
                /* TODO: view response in template */
                return $this->redirect($this->generateUrl('hostkit_client_email_list', array('message' => $response)));
            }
        }

        return $this->render('HostkitClientBundle:Email:list.html.twig', array(
                    'emails' => $emails,
                    'form' => $form->createView(),
                    'domain' => $domain,
                ));
    }

	/**
	 * @param $email
	 *
	 * @return Response
	 */public function deleteAction($email) {
        $array = explode('@', $email);
        $mail = $array['0'];
        
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->delpop($mail);
        
        return new Response('Datensatz erfolgreich gelöscht!');
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function forwardsAction(Request $request) {
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->listpopswithdisk();
        $forwards = $hosting_service->listforwards();
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

        return $this->render('HostkitClientBundle:Email:forwarders.html.twig', array(
                    'emails' => $emails,
                    'forwards' => $forwards,
                    'form' => $form->createView(),
                    'domain' => $domain,
                    'error' => $error,
                ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function mxsAction(Request $request) {
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->listpopswithdisk();
        $mxs = $hosting_service->listmxs();
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

        return $this->render('HostkitClientBundle:Email:mx.html.twig', array(
            'emails' => $emails,
            'mxs' => $mxs,
            'form' => $form->createView(),
            'domain' => $domain,
            'error' => $error,
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function filterAction(Request $request) {
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->listpopswithdisk();
        $filters = $hosting_service->filterlist();
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

        return $this->render('HostkitClientBundle:Email:filter.html.twig', array(
            'emails' => $emails,
            'filters' => $filters,
            'form' => $form->createView(),
            'domain' => $domain,
            'error' => $error,
        ));
    }

}
