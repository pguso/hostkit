<?php

namespace Hostkit\AdminBundle\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\JsonResponse,
    Symfony\Component\HttpFoundation\Session\Session,
    Hostkit\CoreBundle\Entity\Settings,
	Hostkit\AdminBundle\Form\Type\SettingsType,
	Hostkit\CoreBundle\Entity\Payment,
	Hostkit\AdminBundle\Form\Type\PaymentType,
	Hostkit\AdminBundle\Form\Type\UserType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package Hostkit\AdminBundle\Controller\Settings
 */
class DefaultController extends Controller {

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function indexAction(Request $request) {

        $title = array('name' => 'Settings', 'icon' => 'icon-cogs');
		
        $settings = $this->getDoctrine()->getRepository('HostkitCoreBundle:Settings')->findBy(array('id' => 1));
		
		if(count($settings) == 0) {
			$settings = new Settings();
		} else {
			$settings = $settings[0];
		}
		
		$form = $this->get('form.factory')->createNamedBuilder('settings', new SettingsType(), $settings)->getForm();
		//$this->createForm(new SettingsType(), $settings);

        $payment = $this->getDoctrine()->getRepository('HostkitCoreBundle:Payment')->findBy(array('id' => 1));
		
		if(count($payment) == 0) {
			$payment = new Payment();
		} else {
			$payment = $payment[0];
		}

		$form_payment = $this->createForm(new PaymentType(), $payment);
		//$form_user = $this->createForm(new UserType());
		$form_user = $this->get('form.factory')->createNamedBuilder('adminUser', new UserType())->getForm();

        if ($request->getMethod() == 'POST') {


			if($request->request->has('settings')) {
				$form->bind($request);

				if ($form->isValid()) {
					$em = $this->getDoctrine()->getManager();

					$settings->upload();

					$em->persist($settings);
					$em->flush();

				}
			} else if($request->request->has('adminUser')) {
				$form_user->bind($request);

				if ($form_user->isValid()) {
					$userManager = $this->container->get('fos_user.user_manager');
				
					$user = $this->getUser();
					$requestData = $request->request->all();
					
					$user->setPlainPassword($requestData['user']['password']);
					$userManager->updateUser($user);
				}
			
			} else {
				$form_payment->bind($request);

				if ($form_payment->isValid()) {
					$em = $this->getDoctrine()->getManager();
					$em->persist($payment);
					$em->flush();
				}
			}
        }

        return $this->render('HostkitAdminBundle:Settings:index.html.twig', array(
            'form' => $form->createView(),
			'form_payment' => $form_payment->createView(),
			'form_user' => $form_user->createView(),
            'title' => $title
        ));
	}

}
