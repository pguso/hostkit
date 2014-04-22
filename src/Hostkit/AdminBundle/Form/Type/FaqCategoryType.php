<?php



namespace Hostkit\AdminBundle\Form\Type;



use Symfony\Component\Form\AbstractType, 
	Symfony\Component\Form\FormBuilderInterface, 
	Symfony\Component\HttpFoundation\Request, 
	Doctrine\ORM\EntityRepository;


/**
 * Class FaqCategoryType
 * @package Hostkit\AdminBundle\Form\Type
 */
class FaqCategoryType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add("name", "text", array('label' => 'Name', 'attr' => array('class' => 'form-control')))
            ->add('description', 'textarea', array('label' => 'Description', 'required' => true, 'attr' => array('class' => 'form-control')))
		;
    }


	/**
	 * @return string
	 */
	public function getName() {
        return 'faq';
    }


	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\Faq', 'id' => null);
    }



}

