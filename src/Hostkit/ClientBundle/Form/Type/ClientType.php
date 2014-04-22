<?php



namespace Hostkit\ClientBundle\Form\Type;



use Symfony\Component\Form\AbstractType, 
	Symfony\Component\Form\FormBuilderInterface, 
	Symfony\Component\HttpFoundation\Request, 
	Doctrine\ORM\EntityRepository;

use Hostkit\CoreBundle\Entity\SupportTicket;


/**
 * Class SupportType
 * @package Hostkit\ClientBundle\Form\Type
 */
class ClientType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('company', 'text', array('label' => 'Company', 'required' => false))
            ->add('firstname', 'text', array('label' => 'Firstname', 'required' => true))
            ->add('lastname', 'text', array('label' => 'Lastname', 'required' => true))
            ->add('address1', 'text', array('label' => 'Address', 'required' => true))
            ->add('city', 'text', array('label' => 'City', 'required' => true))
            ->add('postcode', 'text', array('label' => 'Postcode', 'required' => true))
            ->add('country', 'text', array('label' => 'Country', 'required' => true))
            ->add('state', 'text', array('label' => 'State', 'required' => true))
            ->add('phone', 'text', array('label' => 'Phone', 'required' => true))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => false,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))

		;
    }


	/**
	 * @return string
	 */
	public function getName() {
        return 'support_ticket';
    }


	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\SupportTicket', 'id' => null);
    }



}

