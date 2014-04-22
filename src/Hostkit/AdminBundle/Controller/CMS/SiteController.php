<?php

namespace Hostkit\AdminBundle\Controller\CMS;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\CoreBundle\Entity\Site,
    Hostkit\AdminBundle\Form\Type\SiteType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class SiteController
 * @package Hostkit\AdminBundle\Controller\CMS
 */
class SiteController extends Controller
{

    /**
     * @return mixed
     */
    public function indexAction()
    {
        $title = array('name' => 'CMS', 'icon' => 'icon-puzzle-piece');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Site');
        $sites = $repository->findAll();

        if(empty($sites)) {
            $sites = '';
        }

        return $this->render('HostkitAdminBundle:CMS:index-site.html.twig', array(
            'sites' => $sites,
            'title' => $title
        ));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function addAction(Request $request)
    {
        $title = array('name' => 'CMS', 'icon' => 'icon-puzzle-piece');
        $error = '';

        $sites = new Site();

        $form = $this->createForm(new SiteType(), $sites);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $sites->setCreatedAt(date("d.m.Y H:i"));

                $em = $this->getDoctrine()->getManager();
                $em->persist($sites);

                try {
                    $em->flush();
                } catch (\Doctrine\DBAL\DBALException $e) {

                    if (is_int(strpos($e->getPrevious()->getMessage(), 'Duplicate entry'))) {
                        $error = 'The name of the site must be a unique name!';
                    } else {
                        $error = $e->getPrevious()->getMessage();
                    }
                }

                if (empty($error)) {
                    return $this->redirect($this->generateUrl('hostkit_xs_cms_site_list'));
                }
            }
        }

        return $this->render('HostkitAdminBundle:CMS:add-site.html.twig', array(
            'title' => $title,
            'form' => $form->createView(),
            'error' => $error
        ));
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return mixed
     */
    public function modifyAction(Request $request, $id)
    {
        $title = array('name' => 'CMS', 'icon' => 'icon-puzzle-piece');

        $em = $this->getDoctrine()->getManager();

        $site = $em->getRepository('HostkitCoreBundle:Site')->find($id);

        $form = $this->createForm(new SiteType(), $site);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                //TODO:add update
                //$sites->setCreatedAt(date("d.m.Y H:i"));

                $em->persist($site);
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_cms_site_list'));
            }
        }

        return $this->render('HostkitAdminBundle:CMS:add-site.html.twig', array(
            'title' => $title,
            'form' => $form->createView(),
            'modify' => 1
        ));
    }

    /**
     * @param $siteId
     *
     * @return Response
     */
    public function deleteAction($siteId) {

        $em = $this->getDoctrine()->getManager();

        $site = $em->getRepository('HostkitCoreBundle:Site')->find($siteId);

        $em->remove($site);
        $em->flush();

        return new Response();
    }
}