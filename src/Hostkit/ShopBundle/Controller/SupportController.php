<?php

namespace Hostkit\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\JsonResponse,
    Symfony\Component\HttpFoundation\Session\Session,
    Hostkit\CoreBundle\Entity\SupportTicket,
	Hostkit\ShopBundle\Form\Type\SupportType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class SupportController
 * @package Hostkit\ShopBundle\Controller
 */
class SupportController extends Controller {

    public function indexAction() {
        $package_ids = '1';

        return $this->render('HostkitShopBundle:Support:index.html.twig', array(
            'package_ids' => $package_ids,
        ));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function addAction(Request $request) {
        $title = 'Support Ticket';

		$message = '';
        $error = '';

        $em = $this->getDoctrine()->getManager();
        $sites = $em->getRepository('HostkitCoreBundle:Site')->findAll();
		
		$supportTicket = new SupportTicket();

        $form = $this->createForm(new SupportType(), $supportTicket);

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $supportTicket->setCreatedAt(date('d-m-Y H:i'));
                $supportTicket->setStatus(1);
                $supportTicket->setParentId(0);

                if(is_object($supportTicket->getDepartment())) {
                    $supportTicket->setDepartment($supportTicket->getDepartment()->getId());
                } else {
                    $supportTicket->setDepartment(0);
                }

                $em->persist($supportTicket);
                $em->flush();
				
				$message = 'Support Ticket created. We will get back to you as soon as possible.';
            }
		}

        return $this->render('HostkitShopBundle:Support:add.html.twig', array(
            'form' => $form->createView(),
			'message' => $message,
            'sites' => $sites
        ));
    }
	
	public function faqAction() {


        $em = $this->getDoctrine()->getManager();
        $faq = $em->getRepository('HostkitCoreBundle:Faq')->findAll();

        $faqCategories = $em->getRepository('HostkitCoreBundle:FaqCategory')->findAll();

        foreach($faq as $question) {
            $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:FaqCategory');
            $faqCategory = $repository->findBy(array('id' => $question->getCategory()));

            $question->setCategory($faqCategory[0]->getName());

        }

        return $this->render('HostkitShopBundle:Support:faq.html.twig', array(
            'faq' => $faq,
            'faqCategory' => $faqCategories
        ));
    }

    public function faqDetailAction($faqId) {
        
        $em = $this->getDoctrine()->getManager();
        $faq = $em->getRepository('HostkitCoreBundle:Faq')->findBy(array('id' => $faqId));

        return new JsonResponse([
            'success' => true,
            'data'    => array('question' => $faq[0]->getQuestion(), 'answer' => $faq[0]->getAnswer())
        ]);
    }

    public function faqCategoryAction($faqCategoryId) {

        $faqList = array();

        $em = $this->getDoctrine()->getManager();
        $faq = $em->getRepository('HostkitCoreBundle:Faq')->findBy(array('category' => $faqCategoryId));

        foreach($faq as $question) {
            $faqList[] = array('id' => $question->getId(), 'question' => $question->getQuestion());
        }

        return new JsonResponse([
            'success' => true,
            'data'    => array('question' => $faq[0]->getQuestion(), 'answer' => $faq[0]->getAnswer(), 'faqList' => $faqList)
        ]);
    }

    public function faqAllAction() {

        $faqList = array();

        $em = $this->getDoctrine()->getManager();
        $faq = $em->getRepository('HostkitCoreBundle:Faq')->findAll();

        foreach($faq as $question) {
            $faqList[] = array('id' => $question->getId(), 'question' => $question->getQuestion());
        }

        return new JsonResponse([
            'success' => true,
            'data'    => array('question' => $faq[0]->getQuestion(), 'answer' => $faq[0]->getAnswer(), 'faqList' => $faqList)
        ]);
    }
	
}