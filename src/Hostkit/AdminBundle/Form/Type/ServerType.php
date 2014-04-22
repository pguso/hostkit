<?php

namespace Hostkit\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType, Symfony\Component\Form\FormBuilderInterface, Symfony\Component\HttpFoundation\Request, Doctrine\ORM\EntityRepository;
use Hostkit\CoreBundle\Entity\Server;

/**
 * Class ServerType
 * @package Hostkit\AdminBundle\Form\Type
 */
class ServerType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('server_name', 'text', array('label' => 'Name', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('ip_address', 'text', array('label' => 'IP Address', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('username', 'text', array('label' => 'Username', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('password', 'password', array('label' => 'Password', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('cost', 'text', array('label' => 'Cost', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('accounts', 'text', array('label' => 'Max. Accounts', 'required' => true, 'attr' => array('class' => 'form-control')));
    }

	/**
	 * @return string
	 */
	public function getName() {
        return 'server';
    }

	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\Server', 'id' => null);
    }

}
