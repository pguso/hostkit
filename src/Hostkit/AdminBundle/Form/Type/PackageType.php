<?php

namespace Hostkit\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType, Symfony\Component\Form\FormBuilderInterface, Symfony\Component\HttpFoundation\Request, Doctrine\ORM\EntityRepository;
use Hostkit\CoreBundle\Entity\Server;

/**
 * Class PackageType
 * @package Hostkit\AdminBundle\Form\Type
 */
class PackageType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add("package_name", "text", array('label' => 'Package Name', "mapped" => false, 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("webspace", "text", array('label' => 'Disk Quota', 'attr'=> array('data-append' => 'MB'), 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("traffic", "text", array('label' => 'Mothly Traffic', 'attr'=> array('data-append' => 'MB'), 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("ftp", "text", array('label' => 'Max. Ftp Accounts', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("email", "text", array('label' => 'Max. E-Mail Accounts', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("email_lists", "text", array('label' => 'Max. E-Mail Lists', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("databases", "text", array('label' => 'Max. Databases', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("subdomains", "text", array('label' => 'Max. Subdomains', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("parked_domains", "text", array('label' => 'Max. Parked DomainHosting', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("addon_domains", "text", array('label' => 'Max. Addon DomainHosting', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("shell", "checkbox", array('label' => 'Shell Access', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add("frontpage", "checkbox", array('label' => 'Frontpage Extension', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add("cgi", "checkbox", array('label' => 'CGI Access', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('theme', 'choice', array('label' => 'cPanel Theme', 'choices'   => array('x3' => 'x3', 'x2' => 'x2'), 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('locale', 'choice', array('label' => 'Locale', 'choices'   => array('en' => 'English', 'de' => 'German'), 'required' => true, 'attr' => array('class' => 'form-control')))

        ;
    }

	/**
	 * @return string
	 */
	public function getName() {
        return 'package';
    }

}
