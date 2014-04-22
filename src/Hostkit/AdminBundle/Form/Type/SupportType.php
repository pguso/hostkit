<?php



namespace Hostkit\AdminBundle\Form\Type;



use Symfony\Component\Form\AbstractType, 
	Symfony\Component\Form\FormBuilderInterface, 
	Symfony\Component\HttpFoundation\Request, 
	Doctrine\ORM\EntityRepository;

use Hostkit\CoreBundle\Entity\SupportTicket;


/**
 * Class SupportType
 * @package Hostkit\AdminBundle\Form\Type
 */
class SupportType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add("user_id", "text", array('label' => 'Staff', 'attr' => array('class' => 'form-control', 'value' => $options['attr']['username']), 'required' => false, 'read_only' => true))
            ->add('description', 'textarea', array('label' => 'Message', 'required' => true, 'attr' => array('class' => 'form-control')))
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

