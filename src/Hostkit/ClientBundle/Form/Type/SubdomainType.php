<?php

namespace Hostkit\ClientBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\HttpFoundation\Request,
    Doctrine\ORM\EntityRepository;

/**
 * Class SubdomainType
 * @package Hostkit\ClientBundle\Form\Type
 */
class SubdomainType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('subdomain', 'text', array('label' => 'Subdomain', 'read_only' => (isset($options['data']['sub']) ? true : false), 'required' => true, 'attr' => array('data-append' => 'dot', 'data-domain' => $options['data']['domain'], 'value' => (isset($options['data']['sub']) ? $options['data']['sub'] : ''))))
            ->add('ip', 'text', array('label' => 'IPv4', 'required' => true, 'attr' => array('value' => (isset($options['data']['ip']) ? $options['data']['ip'] : ''))));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'subdomain';
    }

}
