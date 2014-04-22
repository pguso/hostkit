<?php

namespace Hostkit\ClientBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\HttpFoundation\Request,
    Doctrine\ORM\EntityRepository;

/**
 * Class DomainForwardType
 * @package Hostkit\ClientBundle\Form\Type
 */
class DomainForwardType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('forward', 'text', array('label' => 'Forward to', 'required' => true, 'attr' => array('data-prepend' => 'http')))
            ->add('masking', 'checkbox', array('label' => 'URL Masking', 'required' => false))
            ->add('sub', 'checkbox', array('label' => 'Sub Domain Forwarding', 'required' => false))
            ->add('path', 'checkbox', array('label' => 'Path Forwarding', 'required' => false));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'domain_forward';
    }

}
