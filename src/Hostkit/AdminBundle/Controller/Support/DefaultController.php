<?php

namespace Hostkit\AdminBundle\Controller\Support;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\CoreBundle\Entity\SupportTicket,
    Hostkit\CoreBundle\Entity\SupportDepartment,
    Hostkit\AdminBundle\Form\Type\SupportType,
    Hostkit\AdminBundle\Form\Type\DepartmentType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function listTicketsAction() {
        $title = array('name' => 'Support', 'icon' => 'icon-comments');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportTicket');
        $supportTickets = $repository->findBy(array('parentId' => 0, 'status' => array(1,2)), array('created_at' => 'DESC'));

        foreach($supportTickets as $supportTicket) {
            $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportDepartment');
            $supportDepartment = $repository->findBy(array('id' => $supportTicket->getDepartment()));

            if(!empty($supportDepartment)) {
                $supportTicket->setDepartment($supportDepartment[0]->getName());
            }

        }

        return $this->render('HostkitAdminBundle:Support:index-support.html.twig', array(
        'supportTickets' => $supportTickets,
        'title' => $title
        ));
    }

    public function replyTicketAction(Request $request, $ticketId) {

        $email = array();
        $title = array('name' => 'Support', 'icon' => 'icon-comments');

        $user = $this->get('security.context')->getToken()->getUser();
        $username = $user->getUsername();

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportTicket');
        $supportTicket = $repository->findBy(array('id' => $ticketId));

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings');
        $settings = $repository->findBy(array('id' => 1));

        if(!empty($supportTicket)) {
            $supportTicket = $supportTicket[0];
        }

        $support = new SupportTicket();

        $form = $this->createForm(new SupportType(), $support, array('attr' => array('username' => $username)));

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $support->setCreatedAt(date('d-m-Y H:i'));
                $support->setParentId($supportTicket->getId());
                $support->setRelated(2);

                $em->persist($support);
                $em->flush();

                $supportTicket->setStatus(2);

                $em->persist($supportTicket);
                $em->flush();

                $email['contentTop'] = $support->getDescription();

                $message = \Swift_Message::newInstance()
                    ->setSubject('RE: ' . $supportTicket->getTitle())
                    ->setFrom($settings[0]->getSupportEmail())
                    ->setTo($supportTicket->getEmail())
                    ->setContentType("text/html")
                    //->setBody($this->renderView('HostkitEmailBundle:Example:basic.html.twig'))
                    ->setBody(
                        $this->renderView('HostkitEmailBundle:Default:send.html.twig',
                            array(
                                'settings' => $settings[0],
                                'email' => $email
                            )
                        )
                    );

                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('hostkit_xs_admin_support_tickets'));

            }
        }

        return $this->render('HostkitAdminBundle:Support:reply-support.html.twig', array(
            'form' => $form->createView(),
            'supportTicket' => $supportTicket,
            'title' => $title
        ));
    }

    public function detailTicketAction($ticketId) {
        $title = array('name' => 'Support', 'icon' => 'icon-comments');
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

        return $this->render('HostkitAdminBundle:Support:detail-support.html.twig', array(
            'support' => $support,
            'supportTicket' => $supportTicket,
            'title' => $title
        ));
    }

    public function closeTicketAction($ticketId) {

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportTicket');
        $supportTicket = $repository->findBy(array('id' => $ticketId));

        if(!empty($supportTicket)) {
            $supportTicket = $supportTicket[0];

            $em = $this->getDoctrine()->getManager();

                $supportTicket->setStatus(3);

                $em->persist($supportTicket);
                $em->flush();
        }

        return new Response('closed');
    }

    public function addSupportDepartmentAction(Request $request) {

        $title = array('name' => 'Support', 'icon' => 'icon-comments');
        $message = '';

        $supportDepartment = new SupportDepartment();

        $form = $this->createForm(new DepartmentType(), $supportDepartment);

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($supportDepartment);
                $em->flush();

                if(is_int($supportDepartment->getId())) {
                    $message = 'Successfully added new Support Department!';
                } else {
                    $message = 'Could not save Support Department to Database.';
                }
                

            }
        }

        return $this->render('HostkitAdminBundle:Support:add-department.html.twig', array(
            'form' => $form->createView(),
            'message' => $message,
            'title' => $title
        ));
    }

}