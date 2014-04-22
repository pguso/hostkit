<?php

namespace Hostkit\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class HostkitUserBundle
 * @package Hostkit\UserBundle
 */
class HostkitUserBundle extends Bundle
{
	/**
	 * @return string
	 */
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
