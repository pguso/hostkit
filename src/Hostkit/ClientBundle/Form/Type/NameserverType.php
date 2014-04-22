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
class NameserverType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('ns1', 'text', array('label' => 'Nameserver 1', 'required' => true, 'attr' => array('value' =>
                                                                                                          (array_key_exists(0, $options['data']['ns']) ? $options['data']['ns'][3]->value : ''))
            ))
            ->add('ns2', 'text', array('label' => 'Nameserver 2', 'required' => false, 'attr' => array('value' =>
                                                                                                               (array_key_exists(1, $options['data']['ns']) ? $options['data']['ns'][2]->value : ''))
            ))
            ->add('ns3', 'text', array('label' => 'Nameserver 3', 'required' => false, 'attr' => array('value' =>
                                                                                                               (array_key_exists(2, $options['data']['ns']) ? $options['data']['ns'][1]->value : ''))
            ))
            ->add('ns4', 'text', array('label' => 'Nameserver 4', 'required' => false, 'attr' => array('value' =>
                                                                                                               (array_key_exists(3, $options['data']['ns']) ? $options['data']['ns'][0]->value : ''))
            ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ns';
    }

}
