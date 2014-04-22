<?php



namespace Hostkit\AdminBundle\Form\Type;



use Symfony\Component\Form\AbstractType, 
	Symfony\Component\Form\FormBuilderInterface, 
	Symfony\Component\HttpFoundation\Request, 
	Doctrine\ORM\EntityRepository;


/**
 * Class FaqType
 * @package Hostkit\AdminBundle\Form\Type
 */
class OrderStatusType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            //TODO:order status 0 => 'Pending', 1 => 'Created', 2 => 'Active', 4 => 'Cancelled', 5 => 'Refused'
            ->add("orderStatus", "choice", array('label' => 'Order Status', 'mapped' => false, 'choices' => array(2 => 'Active', 4 => 'Cancelled'), 'attr' => array('class' => 'form-control')))
            ->add('reason', 'text', array('label' => 'Reason', 'mapped' => false, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('sendMail', 'checkbox', array('label' => 'Auto E-Mail', 'mapped' => false, 'required' => false, 'attr' => array('class' => 'form-control')))

        ;
    }


	/**
	 * @return string
	 */
	public function getName() {
        return 'order_status';
    }


	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\Faq', 'id' => null);
    }



}

