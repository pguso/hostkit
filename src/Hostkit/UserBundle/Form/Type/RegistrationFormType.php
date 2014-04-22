<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hostkit\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/**
 * Class RegistrationFormType
 * @package Hostkit\UserBundle\Form\Type
 */
class RegistrationFormType extends BaseType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            //->add('roles', 'choice');
            ->add('roles', 'choice', array(
            'choices' => array(
                'ROLE_RESELL' => 'Reseller',
                'ROLE_SUPPORT' => 'Supporter',
                'ROLE_SYS_ADMIN' => 'Super Admin',
                'ROLE_ADMIN' => 'System Administrator'
            ),
            'empty_value' => false, // user always has at least one role
            'multiple' => true,
            'expanded' => false
        ))
            ;
    }

	/**
	 * @return string
	 */
	public function getName()
    {
        return 'hostkit_user_registration';
    }

}
