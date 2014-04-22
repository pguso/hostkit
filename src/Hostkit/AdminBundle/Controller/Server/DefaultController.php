<?php

namespace Hostkit\AdminBundle\Controller\Server;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\CoreBundle\Entity\Server,
    Hostkit\AdminBundle\Form\Type\ServerType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package Hostkit\AdminBundle\Controller\Server
 */
class DefaultController extends Controller {
	/**
	 * @return mixed
	 */
	public function indexAction() {
        $title = array('name' => 'Server', 'icon' => 'icon-hdd');
        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Server');
        $servers = $repository->findAll();

        return $this->render('HostkitAdminBundle:Server:index.html.twig', array(
            'servers' => $servers,
            'title' => $title
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function addAction(Request $request) {
    $title = array('name' => 'Server', 'icon' => 'icon-hdd');
        $servers = new Server();

        $form = $this->createForm(new ServerType(), $servers);


        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $servers->setStatus(1);

                $em->persist($servers);
                //var_dump($eventDate);die();
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_server_overview'));
            }
        }

        return $this->render('HostkitAdminBundle:Server:add.html.twig', array(
            'servers' => $servers,
            'form' => $form->createView(),
            'title' => $title
        ));
    }

	/**
	 * @param Request $request
	 * @param         $serverId
	 *
	 * @return mixed
	 */public function modifyAction(Request $request, $serverId) {
        //$servers = new Server();
    $title = array('name' => 'Server', 'icon' => 'icon-hdd');
        $em = $this->getDoctrine()->getManager();

        $server = $em->getRepository('HostkitCoreBundle:Server')->find($serverId);
        $form = $this->createForm(new ServerType(), $server);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($server);
                //var_dump($eventDate);die();
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_server_overview'));
            }
        }

        return $this->render('HostkitAdminBundle:Server:add.html.twig', array(
            'form' => $form->createView(),
            'modify' => 1,
            'title' => $title
        ));

    }

	/**
	 * @param $serverId
	 *
	 * @return Response
	 */public function deleteAction($serverId) {
        $em = $this->getDoctrine()->getManager();

        $server = $em->getRepository('HostkitCoreBundle:Server')->find($serverId);

        $em->remove($server);
        $em->flush();

        return new Response();

    }

	/**
	 * @param $serverId
	 *
	 * @return Response
	 */public function defaultAction($serverId) {

        $em = $this->getDoctrine()->getManager();

        $servers = $em->getRepository('HostkitCoreBundle:Server')->findBy(array('used' => 1));

        foreach($servers as $sv) {
            $sv->setUsed(0);

            $em->persist($sv);
            $em->flush();
        }

        $server = $em->getRepository('HostkitCoreBundle:Server')->find($serverId);

        $server->setUsed(1);

        $em->persist($server);
        $em->flush();

        return new Response();

    }
}
