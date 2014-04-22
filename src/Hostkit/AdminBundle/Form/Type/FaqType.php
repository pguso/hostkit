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
class FaqType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
        	->add('category', 'entity', array(
			    'class' => 'HostkitCoreBundle:FaqCategory',
			    'property' => 'name',
                'attr' => array('class' => 'form-control')
			))
            ->add("question", "text", array('label' => 'Question', 'attr' => array('class' => 'form-control')))
            ->add('answer', 'textarea', array('label' => 'Answer', 'required' => true, 'attr' => array('class' => 'form-control')))
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

