<?php

namespace Hostkit\ClientBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\HttpFoundation\Request,
    Doctrine\ORM\EntityRepository;

/**
 * Class IpType
 * @package Hostkit\ClientBundle\Form\Type
 */
class IpType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('value', 'text', array('label' => 'IPv4', 'required' => true, 'attr' => array('value' => $options['data']['ipValue'])));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ip';
    }

}
