<?php

namespace Hostkit\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;
use Hostkit\ClientBundle\Form\Type\EmailType,
    Hostkit\ClientBundle\Form\Type\EmailForwardType;

/**
 * Class FilesController
 * @package Hostkit\ClientBundle\Controller
 */
class FilesController extends Controller {

	/**
	 * @return mixed
	 */
	public function indexAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $hosting_service = $this->container->get('hosting.management.service');
        
        if($user != 'anon.') {
            $file_service = $this->container->get('file.management.service');
            $file_manager = $file_service->getFileManager();
        }

        return $this->render('HostkitClientBundle:Files:index.html.twig', array(
                    'file_manager' => $file_manager
                ));
    }

	/**
	 * @return Response
	 */
	public function directoryAccessAction() {
        $kernel = $this->container->get('kernel')->getRootDir();  //var_dump($kernel);die();
        $path = '/var/www/hostkit/web/img/gallery'; 

       return new Response(shell_exec('ls ' .$path));
    }

	/**
	 * @return Response
	 */
	public function fileManagerAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $p = isset($_POST["path"]) ? $_POST["path"]:"";
        $f = isset($_POST["filter"]) ? $_POST["filter"]:"";
        
        if($user != 'anon.') {
            $file_service = $this->container->get('file.management.service');
            $file_manager = $file_service->getFileManager($p, $f, -1); 
        } else {
            $file_manager = 'Fehler';
        }
        
        return new Response($file_manager);
        
    }

	/**
	 * @return Response
	 */
	public function addFileAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $path = isset($_POST["path"]) ? $_POST["path"]:"";
        $filename = isset($_POST["filename"]) ? $_POST["filename"]:"";
        
        if($user != 'anon.') {
            $file_service = $this->container->get('file.management.service');

            $test = $file_service->addFile($path, $filename);
            $file_manager = $file_service->getFileManager($path, '', '', -1);
        } else {
            $file_manager = 'Fehler';
        }
        
        return new Response($test);
    }

	/**
	 * @return Response
	 */
	public function addFolderAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $path = isset($_POST["path"]) ? $_POST["path"]:"";
        $foldername = isset($_POST["filename"]) ? $_POST["filename"]:"";

        if($user != 'anon.') {
            $file_service = $this->container->get('file.management.service');

            $test = $file_service->addFolder($path, $foldername);
            $file_manager = $file_service->getFileManager($path, '', '', -1);
        } else {
            $file_manager = 'Fehler';
        }

        return new Response($test);
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function webspaceAction(Request $request) {
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->listpopswithdisk();
        $usages = $hosting_service->showmanager();
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

        return $this->render('HostkitClientBundle:Files:webspace.html.twig', array(
            'emails' => $emails,
            'usages' => $usages,
            'form' => $form->createView(),
            'domain' => $domain,
            'error' => $error,
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function ftpAction(Request $request) {
        $hosting_service = $this->container->get('hosting.management.service');
        $emails = $hosting_service->listpopswithdisk();
        $ftps = $hosting_service->listftpwithdisk();
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

        return $this->render('HostkitClientBundle:Files:ftp.html.twig', array(
            'emails' => $emails,
            'ftps' => $ftps,
            'form' => $form->createView(),
            'domain' => $domain,
            'error' => $error,
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */public function backupAction(Request $request) {
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

        return $this->render('HostkitClientBundle:Files:backup.html.twig', array(
            'emails' => $emails,
            'mxs' => $mxs,
            'form' => $form->createView(),
            'domain' => $domain,
            'error' => $error,
        ));
    }

}
