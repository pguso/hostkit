<?php

namespace Hostkit\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType, 
	Symfony\Component\Form\FormBuilderInterface, 
	Symfony\Component\HttpFoundation\Request, 
	Doctrine\ORM\EntityRepository;

use Hostkit\UserBundle\Entity\User;


/**
 * Class SupportType
 * @package Hostkit\AdminBundle\Form\Type
 */
class UserType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add("username", "text", array('label' => 'Username', 'attr' => array('class' => 'form-control', 'value' => 'admin'), 'required' => false, 'read_only' => true))
            ->add('password', 'password', array('label' => 'password', 'required' => false, 'attr' => array('class' => 'form-control')))
		;
    }


	/**
	 * @return string
	 */
	public function getName() {
        return 'user';
    }


	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\UserBundle\Entity\User', 'id' => null);
    }



}

