<?php

namespace Hostkit\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType, Symfony\Component\Form\FormBuilderInterface, Symfony\Component\HttpFoundation\Request, Doctrine\ORM\EntityRepository;
use Hostkit\CoreBundle\Entity\Server;

/**
 * Class DomainType
 * @package Hostkit\AdminBundle\Form\Type
 */
class DomainType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('tld', 'text', array('label' => 'TLD', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('period', 'text', array('label' => 'Period', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('price', 'text', array('label' => 'Price', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('cost', 'text', array('label' => 'Cost', 'required' => true, 'attr' => array('class' => 'form-control')))
        ;
    }

	/**
	 * @return string
	 */
	public function getName() {
        return 'domain_pricing';
    }

	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\DomainPricing', 'id' => null);
    }

}
