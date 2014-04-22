<?php

namespace Hostkit\AdminBundle\Form\Type;


use Symfony\Component\Form\AbstractType, 
	Symfony\Component\Form\FormBuilderInterface, 
	Symfony\Component\HttpFoundation\Request, 
	Doctrine\ORM\EntityRepository;

use Hostkit\CoreBundle\Entity\Payment;


/**
 * Class PaymentType
 * @package Hostkit\AdminBundle\Form\Type
 */
class PaymentType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
			->add("provider", "text", array('label' => 'Payment System', 'required' => true, 'data' => 'paypal', 'read_only' => true, 'attr' => array('class' => 'form-control')))
            ->add('vat', 'text', array('label' => 'VAT Rate', 'required' => true, 'attr' => array('data-append' => '%'), 'attr' => array('class' => 'form-control')))
			->add('currencyCode', 'choice', array('label' => 'Currency Code', 'required' => true,
                'choices' => array(
                    'AUD' => 'AUD',
                    'BRL' => 'BRL',
                    'CAD' => 'CAD',
                    'CZK' => 'CZK',
                    'DKK' => 'DKK',
                    'EUR' => 'EUR',
                    'HKD' => 'HKD',
                    'HUF' => 'HUF',
                    'ILS' => 'ILS',
                    'JPY' => 'JPY',
                    'MYR' => 'MYR',
                    'MXN' => 'MXN',
                    'NOK' => 'NOK',
                    'NZD' => 'NZD',
                    'PHP' => 'PHP',
                    'PLN' => 'PLN',
                    'GBP' => 'GBP',
                    'RUB' => 'RUB',
                    'SGD' => 'SGD',
                    'SEK' => 'SEK',
                    'CHF' => 'CHF',
                    'TWD' => 'TWD',
                    'THB' => 'THB',
                    'TRY' => 'TRY',
                    'USD' => 'USD',
                )
                , 'attr' => array('class' => 'form-control')
            ))
			->add('email', 'text', array('label' => 'Paypal E-Mail Address', 'required' => true, 'attr' => array('class' => 'form-control')))

        ;
    }


	/**
	 * @return string
	 */
	public function getName() {
        return 'payment';
    }


	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\Payment', 'id' => null);
    }



}

