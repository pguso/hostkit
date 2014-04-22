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
class SupportType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('priority', 'choice', array('label' => 'Priority', 'choices'   => array(0 => 'Low', 1 => 'Normal', 2 => 'High', 3 => 'Urgent'), 'required' => true, 'data' => 1, 'attr' => array('class' => 'form-control')))
            ->add('title', 'text', array('label' => 'Subject', 'required' => true, 'attr' => array('class' => 'form-control', 'value' => ($options['data']['serviceId'] > 0 ? 'Question to Service ID#' . $options['data']['serviceId'] : ''))))
            ->add('description', 'textarea', array('label' => 'Message', 'required' => true, 'attr' => array('class' => 'form-control')))
			->add('department', 'entity', array(
			    'class' => 'HostkitCoreBundle:SupportDepartment',
			    'property' => 'name',
			    'required' => true, 
			    'attr' => array('class' => 'form-control')
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

