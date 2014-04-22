<?php
namespace Hostkit\ClientBundle\Extensions;

use Symfony\Component\HttpFoundation\Session,
    Doctrine\ORM\EntityManager,
    Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TwigVars extends Controller {
    protected $session;
    protected $em;

    function __construct($context, $em) {
        $this->context = $context;
        $this->em = $em;
    }

    public function getUserId() {
        $userId = $this->context->getToken()->getUser()->getId();

        return $userId;
    }

    public function getShowFaq() {
        $showFaq = false;

        $faq = $this->em->getRepository('HostkitCoreBundle:Faq')->findAll();

        if(count($faq) > 0) {
            $showFaq = true;
        }

        return $showFaq;
    }

    public function getShowPackages() {
        $showPackages = false;

        $products = $this->em->getRepository('HostkitCoreBundle:Product')->findAll();

        if(count($products) > 0) {
            $showPackages = true;
        }

        return $showPackages;
    }

}