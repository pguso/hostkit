<?php

namespace Hostkit\AdminBundle\Controller\Cpanel;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\AdminBundle\Form\Type\PackageType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\JsonResponse,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class PackagesController
 * @package Hostkit\AdminBundle\Controller\Cpanel
 */
class PackagesController extends Controller {

    private $server = '';
    private $packages = '';

	/**
	 * @return mixed
	 */
	public function indexAction() {

        $title = array('name' => 'cPanel Connect', 'icon' => 'icon-chain');

        if($this->get("hosting.management.service")->getErrors() != 201) {
            $this->packages = $this->get("hosting.management.service")->listPackages();
        }

        $em = $this->getDoctrine()->getManager();

        $servers = $em->getRepository('HostkitCoreBundle:Server')->findAll();

        if(!empty($servers)) {
            $this->server = $servers[0]->getServerName();
        }

        return $this->render('HostkitAdminBundle:Cpanel:index-packages.html.twig', array(
            'packages' => $this->packages,
            'servers' => $servers,
            'server' => $this->server,
            'connectionError' => $this->get("hosting.management.service")->getErrors(),
            'title' => $title
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function addAction(Request $request) {
    $title = array('name' => 'cPanel Connect', 'icon' => 'icon-chain');
        $error = '';

        $form = $this->createForm(new PackageType());

        if($this->get("hosting.management.service")->getErrors() != 201) {
            $this->featureList = $this->get("hosting.management.service")->listPackages();
        }


        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();
                $params = array(
                    'name' => $requestData['package']['package_name'],
                    'quota' => $requestData['package']['webspace'],
                    'bwlimit' => $requestData['package']['traffic'],
                    'maxftp' => $requestData['package']['ftp'],
                    'maxpop' => $requestData['package']['email'],
                    'maxlst' => $requestData['package']['email_lists'],
                    'maxsql' => $requestData['package']['databases'],
                    'maxsub' => $requestData['package']['subdomains'],
                    'maxpark' => $requestData['package']['parked_domains'],
                    'maxaddon' => $requestData['package']['addon_domains'],
                    'hasshell' => (isset($requestData['package']['shell']) ? $requestData['package']['shell'] : 0),
                    'frontpage' => (isset($requestData['package']['frontpage']) ? $requestData['package']['frontpage'] : 0),
                    'cgi' => (isset($requestData['package']['cgi']) ? $requestData['package']['cgi'] : 0),
                    'cpmod' => $requestData['package']['theme'],
                    'language' => $requestData['package']['locale']
                    );

                $response = $this->get("hosting.management.service")->getCpanelApi()->addpkg($params);

                if($response->result->status == 1) {
                    return $this->redirect($this->generateUrl('hostkit_xs_cpanel_packages_overview'));
                } else {
                    $error = $response->result->statusmsg;
                }


            }
        }

        return $this->render('HostkitAdminBundle:Cpanel:add-packages.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
            'title' => $title
        ));
    }

	/**
	 * @param Request $request
	 * @param         $packageId
	 *
	 * @return mixed
	 */public function modifyAction(Request $request, $packageId) {

    $title = array('name' => 'cPanel Connect', 'icon' => 'icon-chain');
        $error = '';

        $packageInfo = $this->get("hosting.management.service")->getCpanelApi()->getpkginfo($packageId);

        $form = $this->createForm(new PackageType());

        $form->get('package_name')->setData($packageId);
        $form->get('webspace')->setData((string)$packageInfo->data->pkg->QUOTA);
        $form->get('traffic')->setData((string)$packageInfo->data->pkg->BWLIMIT);
        $form->get('ftp')->setData((string)$packageInfo->data->pkg->MAXFTP);
        $form->get('email')->setData((string)$packageInfo->data->pkg->MAXPOP);
        $form->get('email_lists')->setData((string)$packageInfo->data->pkg->MAXLST);
        $form->get('databases')->setData((string)$packageInfo->data->pkg->MAXSQL);
        $form->get('subdomains')->setData((string)$packageInfo->data->pkg->MAXSUB);
        $form->get('parked_domains')->setData((string)$packageInfo->data->pkg->MAXPARK);
        $form->get('addon_domains')->setData((string)$packageInfo->data->pkg->MAXADDON);
        $form->get('frontpage')->setData((string)$packageInfo->data->pkg->FRONTPAGE == 1 ? true : false);
        $form->get('shell')->setData((string)$packageInfo->data->pkg->HASSHELL == 1 ? true : false);
        $form->get('cgi')->setData((string)$packageInfo->data->pkg->CGI == 1 ? true : false);
        $form->get('theme')->setData((string)$packageInfo->data->pkg->CPMOD);
        $form->get('locale')->setData((string)$packageInfo->data->pkg->LANG);

        if($this->get("hosting.management.service")->getErrors() != 201) {
            $this->featureList = $this->get("hosting.management.service")->listPackages();
        }


        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();
                $params = array(
                    'name' => $requestData['package']['package_name'],
                    'quota' => $requestData['package']['webspace'],
                    'bwlimit' => $requestData['package']['traffic'],
                    'maxftp' => $requestData['package']['ftp'],
                    'maxpop' => $requestData['package']['email'],
                    'maxlst' => $requestData['package']['email_lists'],
                    'maxsql' => $requestData['package']['databases'],
                    'maxsub' => $requestData['package']['subdomains'],
                    'maxpark' => $requestData['package']['parked_domains'],
                    'maxaddon' => $requestData['package']['addon_domains'],
                    'hasshell' => (isset($requestData['package']['shell']) ? $requestData['package']['shell'] : 0),
                    'frontpage' => (isset($requestData['package']['frontpage']) ? $requestData['package']['frontpage'] : 0),
                    'cgi' => (isset($requestData['package']['cgi']) ? $requestData['package']['cgi'] : 0),
                    'cpmod' => $requestData['package']['theme'],
                    'language' => $requestData['package']['locale']
                );

                $response = $this->get("hosting.management.service")->getCpanelApi()->editpkg($params);

                if($response->result->status == 1) {
                    return $this->redirect($this->generateUrl('hostkit_xs_cpanel_packages_overview'));
                } else {
                    $error = $response->result->statusmsg;
                }
            }

            }

        return $this->render('HostkitAdminBundle:Cpanel:add-packages.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
            'modify' => 1,
            'title' => $title
        ));
    }

	/**
	 * @param $packageId
	 *
	 * @return JsonResponse
	 */public function deleteAction($packageId) {

    $title = array('name' => 'cPanel Connect', 'icon' => 'icon-chain');
        $error = '';

        $packageInfo = $this->get("hosting.management.service")->getCpanelApi()->killpkg($packageId);

        if((string)$packageInfo->result->status == 0) {
            $error = (string)$packageInfo->result->statusmsg;
        }

        return new JsonResponse($error);
    }

	/**
	 * @param $packageId
	 *
	 * @return mixed
	 */public function detailAction($packageId) {

    $title = array('name' => 'cPanel Connect', 'icon' => 'icon-chain');
        $error = '';

        $packageInfo = $this->get("hosting.management.service")->getCpanelApi()->getpkginfo($packageId);

        if((string)$packageInfo->metadata->result == 1) {
            $packageInfo = $packageInfo->data->pkg;
        } else {
            $packageInfo = (string)$packageInfo->metadata->reason;
        }


        return $this->render('HostkitAdminBundle:Cpanel:detail-packages.html.twig', array(
            'packageInfos' => $packageInfo,
            'title' => $title
        ));
    }
}
