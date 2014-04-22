<?php

namespace Hostkit\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\CoreBundle\Entity\Email,
    Hostkit\EmailBundle\Form\Type\EmailType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction($name) {
        $title = array('name' => 'CMS', 'icon' => 'icon-puzzle-piece');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings');
        $settings = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Email');
        $email = $repository->findBy(array('name' => $name));

        if (!empty($email)) {
            $email = $email[0];
        }

        return $this->render('HostkitEmailBundle:Default:index.html.twig', array(
            'settings' => $settings[0],
            'email'    => $email,
            'title' => $title
        ));
    }

    public function sendAction($name, $clientId, $params = array()) {

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Email');
        $email = $repository->findBy(array('name' => $name));

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
        $client = $repository->findBy(array('id' => $clientId));

        if (!empty($email)) {
            $email = $email[0];
        }

        if (!empty($client)) {
            $client = $client[0];
        }

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings');
        $settings = $repository->findAll();

        $message = \Swift_Message::newInstance()
            ->setSubject($email->getSubject())
            ->setFrom($settings[0]->getCompanyEmail())
            ->setTo($client->getEmail())
            ->setContentType("text/html")
            //->setBody($this->renderView('HostkitEmailBundle:Example:basic.html.twig'))
            ->setBody(
                $this->renderView('HostkitEmailBundle:Default:send.html.twig',
                    array(
                        'settings' => $settings[0],
                        'params'   => $params,
                        'client'   => $client,
                        'email'    => $email,
                    )
                )
            );

        $mail = $this->get('mailer')->send($message);
		

        return $this->render('HostkitEmailBundle:Default:send.html.twig', array(
            'settings' => $settings[0],
            'email'    => $email,
            'params'   => $params,
            'client'   => $client
        ));
    }

    public function sendCustomAction($emailDetails, $clientId, $params = array()) {


        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client');
        $client = $repository->findBy(array('id' => $clientId));

        if (!empty($client)) {
            $client = $client[0];
        }

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings');
        $settings = $repository->findAll();

        $message = \Swift_Message::newInstance()
            ->setSubject($emailDetails['subject'])
            ->setFrom($settings[0]->getCompanyEmail())
            ->setTo($client->getEmail())
            ->setContentType("text/html")
            ->setBody(
                $this->renderView('HostkitEmailBundle:Default:send_custom.html.twig',
                    array(
                        'settings' => $settings[0],
                        'params'   => $params,
                        'client'   => $client,
                        'email'    => $emailDetails,
                    )
                )
            );

        $this->get('mailer')->send($message);

        return $this->render('HostkitEmailBundle:Default:send_custom.html.twig', array(
            'settings' => $settings[0],
            'email'    => $emailDetails,
            'params'   => $params,
            'client'   => $client
        ));
    }

    public function addAction(Request $request) {
        $title = array('name' => 'CMS', 'icon' => 'icon-puzzle-piece');
        $email = new Email();

        $form = $this->createForm(new EmailType(), $email);

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($email);
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_email_list'));

            }
        }

        return $this->render('HostkitEmailBundle:Default:add.html.twig', array(
            'form' => $form->createView(),
            'title' => $title
        ));

    }

    public function modifyAction(Request $request, $id) {

        $title = array('name' => 'CMS', 'icon' => 'icon-puzzle-piece');
        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Email');
        $email = $repository->findBy(array('id' => $id));

        if (!empty($email)) {
            $email = $email[0];
        }

        $form = $this->createForm(new EmailType(), $email, array('attr' => array('emailId' => $id)));

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($email);
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_email_list'));

            }
        }

        return $this->render('HostkitEmailBundle:Default:add.html.twig', array(
            'form'   => $form->createView(),
            'modify' => 1,
            'title' => $title
        ));

    }

    public function listAction() {

        $title = array('name' => 'CMS', 'icon' => 'icon-puzzle-piece');
        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Email');
        $emails = $repository->findAll();

        return $this->render('HostkitEmailBundle:Default:list.html.twig', array(
            'emails' => $emails,
            'title' => $title
        ));
    }

    public function deleteAction($emailId) {
        $em = $this->getDoctrine()->getManager();

        $email = $em->getRepository('HostkitCoreBundle:Email')->find($emailId);

        $em->remove($email);
        $em->flush();

        return new Response($email->getId());
    }
}
