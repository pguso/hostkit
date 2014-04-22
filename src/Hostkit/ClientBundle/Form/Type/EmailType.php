<?php

namespace Hostkit\ClientBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\HttpFoundation\Request,
    Doctrine\ORM\EntityRepository;
	
use WBU\ClientBundle\Entity\Category;

/**
 * Class EmailType
 * @package Hostkit\ClientBundle\Form\Type
 */
class EmailType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder 
                ->add('email', 'text', array('label' => 'E-Mail', 'required' => true))
                ->add('quota', 'text', array('label' => 'Speicher', 'required' => true))
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'Die Passwort Felder müssen übereinstimmen.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options'  => array('label' => 'Passwort'),
                    'second_options' => array('label' => 'Passwort wiederholen'),
                ))
                //autocomplete='off'
                ->add('proof', 'hidden', array('attr' => array('id' => 'proof', 'value' => '')))
                //->add('image', 'file', array('label' => 'Bild', 'required' => false))
            
            ;
    }

	/**
	 * @return string
	 */
	public function getName() {
        return 'email';
    }

//    public function getDefaultOptions(array $options) {
//        return array(
//            'data_class' => 'Hostkit\CoreBundle\Entity\Category',
//            'id' => null
//        );
//    }

}
