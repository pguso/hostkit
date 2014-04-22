<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
	/**
	 * @return array
	 */
	public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
			new Hampe\Bundle\ZurbInkBundle\HampeZurbInkBundle(),
			new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle(),
			new FOS\UserBundle\FOSUserBundle(),
			new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
			new PUGX\I18nBundle\PUGXI18nBundle(),
			
            new Hostkit\AdminBundle\HostkitAdminBundle(),
            new Hostkit\CoreBundle\HostkitCoreBundle(),
            new Hostkit\ShopBundle\HostkitShopBundle(),
            new Hostkit\UserBundle\HostkitUserBundle(),
			new Hostkit\ClientBundle\HostkitClientBundle(),
            new Hostkit\EmailBundle\HostkitEmailBundle(),
            new Hostkit\SetupBundle\HostkitSetupBundle()
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        }

        return $bundles;
    }

	/**
	 * @param LoaderInterface $loader
	 */
	public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
