<?php

namespace Hostkit\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType, Symfony\Component\Form\FormBuilderInterface, Symfony\Component\HttpFoundation\Request, Doctrine\ORM\EntityRepository;
use Hostkit\CoreBundle\Entity\Server;

/**
 * Class AccountType
 * @package Hostkit\AdminBundle\Form\Type
 */
class AccountType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add("domain", "text", array('label' => 'Domain', "mapped" => false, 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("username", "text", array('label' => 'Username', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field form-control')),
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add("email", "text", array('label' => 'E-Mail Address', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('package', 'choice', array('label' => 'Choose a Package', 'choices'   => $options['attr'], 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('locale', 'choice', array('label' => 'Locale', 'choices'   => array('en' => 'English', 'de' => 'German'), 'required' => true, 'attr' => array('class' => 'form-control')))

        ;
    }

	/**
	 * @return string
	 */
	public function getName() {
        return 'account';
    }

}
