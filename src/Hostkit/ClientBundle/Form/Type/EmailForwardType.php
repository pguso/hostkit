<?php

namespace Hostkit\ClientBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\HttpFoundation\Request,
    Doctrine\ORM\EntityRepository;

/**
 * Class EmailForwardType
 * @package Hostkit\ClientBundle\Form\Type
 */
class EmailForwardType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('name', 'text', array('label' => 'Name', 'required' => true, 'attr' => array('data-append' => '@', 'data-domain' => $options['data']['domain'])))
            ->add('forward', 'text', array('label' => 'Forward to', 'required' => true));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'email_forward';
    }

}
