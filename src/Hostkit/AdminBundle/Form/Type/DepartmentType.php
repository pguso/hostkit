<?php



namespace Hostkit\AdminBundle\Form\Type;



use Symfony\Component\Form\AbstractType, 
	Symfony\Component\Form\FormBuilderInterface, 
	Symfony\Component\HttpFoundation\Request, 
	Doctrine\ORM\EntityRepository;



/**
 * Class DepartmentType
 * @package Hostkit\AdminBundle\Form\Type
 */
class DepartmentType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add("name", "text", array('label' => 'Department Name', 'attr' => array('class' => 'form-control'), 'required' => true))
            ->add('description', 'textarea', array('label' => 'Description', 'required' => true, 'attr' => array('class' => 'form-control')))
		;
    }


	/**
	 * @return string
	 */
	public function getName() {
        return 'department';
    }


	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\Department', 'id' => null);
    }



}

