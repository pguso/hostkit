<?php

namespace Hostkit\AdminBundle\Controller\Support;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\CoreBundle\Entity\Faq,
    Hostkit\CoreBundle\Entity\FaqCategory,
    Hostkit\AdminBundle\Form\Type\FaqType,
    Hostkit\AdminBundle\Form\Type\FaqCategoryType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

class FaqController extends Controller {

    public function indexAction() {
        $title = array('name' => 'Support', 'icon' => 'icon-comments');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Faq');
        $faq = $repository->findAll();

        foreach($faq as $question) {
            $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:FaqCategory');
            $faqCategory = $repository->findBy(array('id' => $question->getCategory()));

            $question->setCategory($faqCategory[0]->getName());

        }

        return $this->render('HostkitAdminBundle:Support:index-faq.html.twig', array(
        'faq' => $faq,
        'title' => $title
        ));
    }


    public function deleteAction($faqId) {

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Faq');
        $faq = $repository->findBy(array('id' => $faqId));

        if(!empty($faq)) {
            $faq = $faq[0];

                $em = $this->getDoctrine()->getManager();

                $em->remove($faq);
                $em->flush();
        }

        return new Response('closed');
    }

    public function addAction(Request $request) {

        $message = '';
        $title = array('name' => 'Support', 'icon' => 'icon-comments');

        $faq = new Faq();

        $form = $this->createForm(new FaqType(), $faq);

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $faq->setCategory($faq->getCategory()->getId());

                $em->persist($faq);
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_admin_support_faq'));
                
            }
        }

        return $this->render('HostkitAdminBundle:Support:add-faq.html.twig', array(
            'form' => $form->createView(),
            'message' => $message,
            'title' => $title
        ));
    }

    public function addCategoryAction(Request $request) {

        $message = '';
        $title = array('name' => 'Support', 'icon' => 'icon-comments');

        $faq = new FaqCategory();

        $form = $this->createForm(new FaqCategoryType(), $faq);

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($faq);
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_admin_support_faq'));
                
            }
        }

        return $this->render('HostkitAdminBundle:Support:add-faq-category.html.twig', array(
            'form' => $form->createView(),
            'message' => $message,
            'title' => $title
        ));
    }

    public function modifyAction(Request $request, $faqId) {

        $message = '';
        $title = array('name' => 'Support', 'icon' => 'icon-comments');

        $repository = $this->getDoctrine()->getRepository('HostkitCoreBundle:Faq');
        $faq = $repository->findBy(array('id' => $faqId));

        if(!empty($faq)) {
            $faq = $faq[0];
        }

        $form = $this->createForm(new FaqType(), $faq);

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $faq->setCategory($faq->getCategory()->getId());

                $em->persist($faq);
                $em->flush();

                return $this->redirect($this->generateUrl('hostkit_xs_admin_support_faq'));
                
            }
        }

        return $this->render('HostkitAdminBundle:Support:add-faq.html.twig', array(
            'form' => $form->createView(),
            'message' => $message,
            'title' => $title
        ));
    }

}