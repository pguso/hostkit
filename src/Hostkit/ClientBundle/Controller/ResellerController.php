<?php

namespace Hostkit\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ResellerController
 * @package Hostkit\ClientBundle\Controller
 */
class ResellerController extends Controller
{
    public function overviewAction()
    {

        return $this->render('HostkitClientBundle:Reseller:overview.html.twig',
                array(
                    'name' => ''
                    ));
    }
    
    /*
     * 
     * connects to the cpanel api
     * 
     */
    public function hostingAction()
    {
        return $this->render('HostkitClientBundle:Hosting:index.html.twig',
                array(
                    'name' => ''
                    ));
    }
}
