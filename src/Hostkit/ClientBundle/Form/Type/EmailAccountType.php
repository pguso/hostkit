<?php

namespace Hostkit\ClientBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\HttpFoundation\Request,
    Doctrine\ORM\EntityRepository;
	
/**
 * Class EmailAccountType
 * @package Hostkit\ClientBundle\Form\Type
 */
class EmailAccountType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder 
                ->add('name', 'text', array('label' => 'Name', 'required' => true, 'attr' => array('data-append' => '@', 'data-domain' => $options['data']['domain'])))
            ;
    }

	/**
	 * @return string
	 */
	public function getName() {
        return 'email_account';
    }

}
