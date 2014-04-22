<?php
/**
 * User: patric gutersohn
 * Date: 06.04.13
 * Time: 22:15
 * To change this template use File | Settings | File Templates.
 */

namespace Hostkit\UserBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class LoginListener
 * @package Hostkit\UserBundle\Listener
 */
class LoginListener
{
    protected $doctrine;

	/**
	 * @param                 $container
	 * @param SecurityContext $securityContext
	 */
	public function __construct($container, SecurityContext $securityContext)
    {
        $this->container= $container;
        $this->securityContext = $securityContext;
    }

	/**
	 * @param InteractiveLoginEvent $event
	 *
	 * @return mixed
	 */public function onLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        //$role = $user->getRoles();

        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            $controller = 'HostkitAdminBundle:Dashboard\Default:index'; //var_dump($this->container->get('http_kernel')->forward($controller));die();

            return $this->container->get('http_kernel')->forward($controller);

        } elseif($this->securityContext->isGranted('ROLE_USER')) {
            $controller = 'HostkitClientBundle:Default:dashboard';

            return $this->container->get('http_kernel')->forward($controller);

        }

    }
}
