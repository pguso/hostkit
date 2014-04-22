<?php

namespace Hostkit\SetupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Hostkit\SetupBundle\Library\SymfonyRequirements;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$requirements = new SymfonyRequirements();
		$iniPath = $requirements->getPhpIniConfigPath();
		
		$checkPassed = true;
		
		foreach ($requirements->getRequirements() as $req) {
			/** @var $req Requirement */
			//echo_requirement($req);
			if (!$req->isFulfilled()) {
				$checkPassed = false;
			}
		} //var_dump($requirements->getRequirements());die();
	
        return $this->render('HostkitSetupBundle:Default:index.html.twig', array(
			'requirements' => $requirements->getRequirements(),
			'passed' => $checkPassed
		));
    }
}
