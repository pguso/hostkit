<?php

namespace Hostkit\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Hostkit\CoreBundle\Entity\Client,
    Hostkit\ClientBundle\Form\Type\ClientType;

/**
 * Class DefaultController
 * @package Hostkit\ClientBundle\Controller
 */
class DefaultController extends Controller {
    /**
     * @param $error
     *
     * @return mixed
     */
    public function dashboardAction($error) {

        //knob boxes - webspace / traffic /dbs
        $services = array();
        $traffic = array();
        $dbs = array();
        $ordered_items = array();
        $cpanel = '';
		$domainExists = 1;

        $userId = $this->getUser()->getId();

        $repository = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:OrderItem');
			
		$client = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Client')->findBy(array('user_id' => $userId));
		
		if(!empty($client)) {
			$client = $client[0];
		}

        if (!empty($userId)) {
            $active_items = $repository->findBy(array('user_id' => $userId, 'status' => 3));
            $ordered_items = $repository->findBy(array('user_id' => $userId, 'service' => 3));

            foreach ($active_items as $active_item) {

                $domain = $active_item->getPackageDomain();
                $username = substr(str_replace('.', '', $domain), 0, 8);

                $cpanel = $this->container->get('hosting.management.service')->getCpanelApi();
				if(!is_int($cpanel)) {
					$account = $cpanel->accountsummary($username);
				}

                if (isset($account)) { //TODO: change condition
                    $limit = 0;
                    $used = 0;
                    $dbs = 0;
                    $maxDbs = 0;

                    foreach ($account->acct as $acc) {

                        $limit = ($limit + (integer)$acc->disklimit);
                        $used = ($used + (integer)$acc->diskused);
                        $maxDbs = ($dbs + (integer)$acc->maxsql);
                        $maxSub = (integer)$acc->maxsub;
                    }


                    $dbs = $cpanel->api2_query($username, 'MysqlFE', 'listdbs');
                    $dbs = ( array_key_exists('db', (array)$dbs->data[0]) ? count($dbs->data) : 0);

                    $sub = $cpanel->api1_query($username, 'SubDomain', 'listsubdomains');
                    $sub = ( array_key_exists('result', (array)$sub->data[0]) ? count($sub->data) : 0);


                    $services['webspace'] = array('used' => $used, 'limit' => $limit);
                    $services['dbs'] = array('dbs_used' => $dbs, 'dbs_max' => $maxDbs);
                    $services['sub'] = array('sub_used' => $sub, 'sub_max' => $maxSub);
                }

            }

            foreach ($ordered_items as $ordered_item) {
                $id = $ordered_item->getPackageId();

                $repository = $this->getDoctrine()
                    ->getRepository('HostkitCoreBundle:Product');

                $product = $repository->findBy(array('id' => $id), array(), 1);

                if (!empty($product)) {
                    $ordered_item->setPackageId($product[0]->getName());
                }
            }
        }

		$supportTickets = $this->getDoctrine()
                    ->getRepository('HostkitCoreBundle:SupportTicket')->findBy(array('user_id' => $userId), array('id' => 'DESC'));
					
		$invoices = $this->getDoctrine()
                    ->getRepository('HostkitCoreBundle:Invoice')->findBy(array('userId' => $userId), array('id' => 'DESC'));
					
		foreach($invoices as $invoice) {
			$date = new \Datetime($invoice->getDate());
			$invoice->setDate($date->format('F Y'));
		}
		
		if(empty($supportTickets)) {
			$supportTickets = null;
		}
		
		if(empty($invoices)) {
			$invoices = null;
		}

        if ($error !== 0) {
            $error = 'Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Systemadministrator';
        }

        return $this->render('HostkitClientBundle:Default:dashboard.html.twig',
            array(
                'ordered_items' => $ordered_items,
                'error'         => $error,
                'services'      => $services,
				'invoices' => $invoices,
				'supportTickets' => $supportTickets
            ));
    }

    /**
     * @return mixed
     */
    public function settingsAction(Request $request, $userId) {

        $message = '';

        $client = $this->getDoctrine()
            ->getRepository('HostkitCoreBundle:Client')->findBy(array('user_id' => $userId));

        $client = $client[0];

        $form = $this->createForm(new ClientType(), $client);


        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($client);
                $em->flush();

            }

            $message = 'Updated information successfully.';
        }

        return $this->render('HostkitClientBundle:Settings:index.html.twig',
            array(
                'message' => $message,
                'form' => $form->createView()
            ));
    }
}
