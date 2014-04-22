<?php

namespace Hostkit\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType, 
	Symfony\Component\Form\FormBuilderInterface, 
	Symfony\Component\HttpFoundation\Request, 
	Doctrine\ORM\EntityRepository,
	Hostkit\CoreBundle\Entity\Site;

/**
 * Class SiteType
 * @package Hostkit\AdminBundle\Form\Type
 */
class SiteType extends AbstractType {


	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('title', 'text', array('label' => 'Title', 'required' => true, 'attr' => array('class' => 'form-control')))
			->add('name', 'text', array('label' => 'Name', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('content', 'textarea', array('label' => 'Site Content', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('menu', 'choice', array('label' => 'Menu', 'required' => true, 'choices'   => array(0 => 'No Menu', 1 => 'Main Menu', 2 => 'Footer Menu'), 'attr' => array('class' => 'form-control')))
			;
    }


	/**
	 * @return string
	 */
	public function getName() {
        return 'site';
    }


	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\Site', 'id' => null);
    }



}

