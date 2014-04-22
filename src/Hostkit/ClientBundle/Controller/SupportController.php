<?php

namespace Hostkit\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;
	
use Hostkit\ClientBundle\Form\Type\SupportType,
    Hostkit\CoreBundle\Entity\SupportTicket;

/**
 * Class StatisticsController
 * @package Hostkit\ClientBundle\Controller
 */
class SupportController extends Controller {

	/**
	 *
	 * @return mixed
	 */
	 public function indexAction() {
		$user = $this->get('security.context')->getToken()->getUser();
		$userId = $user->getId();
		
		$repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportTicket');
        $supportTickets = $repository->findBy(array('user_id' => $userId));

		return $this->render('HostkitClientBundle:Support:index.html.twig', array(
			'supportTickets' => $supportTickets
        ));
	 }
	 
	 /**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function addAction(Request $request, $service) {
	 
		$user = $this->get('security.context')->getToken()->getUser();
		$userId = $user->getId();
	 
		$message = '';
		$supportTicket = new SupportTicket();
	 
		$form = $this->createForm(new SupportType(), $supportTicket, array('data' => array('serviceId' => $service)));
	 
	    if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

				$supportTicket->setUserId($userId);
				$supportTicket->setDepartment($supportTicket->getDepartment()->getId());
				$supportTicket->setCreatedAt(date('d-m-Y H:i'));
				$supportTicket->setStatus(1);
				
                $em->persist($supportTicket);
                $em->flush();
				
				if(is_int($supportTicket->getId())) {
					$message = 'Thank you we will answer to this Support Ticket as soon as possible.';
				} else {
					$message = 'Something went wrong. Please try again later.';
				}

            }
        }
		
		return $this->render('HostkitClientBundle:Support:add.html.twig', array(
			'message' => $message,
			'form' => $form->createView()
        ));
	 
	 }
	 
	 public function detailAction($ticketId) {

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportTicket');
        $supportTicket = $repository->findBy(array('id' => $ticketId));

        if(!empty($supportTicket)) {
            $supportTicket = $supportTicket[0];
        }

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportTicket');
        $support = $repository->findBy(array('parentId' => $ticketId));

        if(!empty($support)) {
            $support = $support[0];
        }

        return $this->render('HostkitClientBundle:Support:detail.html.twig', array(
            'support' => $support,
            'supportTicket' => $supportTicket
        ));
    }
	 
}