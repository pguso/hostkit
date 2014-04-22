<?php

namespace Hostkit\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType, Symfony\Component\Form\FormBuilderInterface, Symfony\Component\HttpFoundation\Request, Doctrine\ORM\EntityRepository;
use Hostkit\CoreBundle\Entity\Server;

/**
 * Class ProductType
 * @package Hostkit\AdminBundle\Form\Type
 */
class ProductType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('catId', 'choice', array('label' => 'Category', 'choices'   => array('1' => 'Shared Hosting', '2' => 'Reseller Hosting'), 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('name', 'text', array('label' => 'Packagename', 'required' => true, 'attr' => array('class' => 'form-control')))
            //->add('description', 'textarea', array('label' => 'Description', 'required' => true))
            ->add("webspace", "text", array("mapped" => false, 'attr'=> array('data-append' => 'MB'), 'attr' => array('class' => 'form-control')))
            ->add("traffic", "text", array("mapped" => false, 'attr'=> array('data-append' => 'MB'), 'attr' => array('class' => 'form-control')))
            ->add("databases", "text", array('label' => 'MySQL Databases',"mapped" => false, 'attr' => array('class' => 'form-control')))
            ->add("ftp", "text", array('label' => 'FTP Accounts', "mapped" => false, 'attr' => array('class' => 'form-control')))
            ->add("email", "text", array('label' => 'E-Mail Addresses', "mapped" => false, 'attr' => array('class' => 'form-control')))
            //->add('payment', 'text', array('label' => 'Payment', 'required' => true))
            ->add('quantity', 'text', array('label' => 'Quantity', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('cpanel_package', 'choice', array('label' => 'cPanel Package', 'required' => false, 'choices'   => $options['attr'], 'attr' => array('class' => 'form-control')))
            ->add('featured', 'checkbox', array('label' => 'Featured', 'required' => false, 'attr' => array('class' => 'form-control')))
			
			//pricing stuff
			->add('typeId', 'choice', array('label' => 'Payment Type', 'choices'   => array('1' => 'One Time', '2' => 'Recurring', '3' => 'Free'), 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('price', 'text', array('label' => 'Price', 'required' => false, 'attr'=> array('data-prepend' => '$'), 'attr' => array('class' => 'form-control')))
			->add("monthly", "text", array('label' => 'Monthly', 'required' => false, 'attr'=> array('data-prepend' => '$'), 'attr' => array('class' => 'form-control')))
			->add("quarterly", "text", array('label' => 'Quarterly', 'required' => false, 'attr'=> array('data-prepend' => '$'), 'attr' => array('class' => 'form-control')))
			->add("semiannual", "text", array('label' => 'Semiannual', 'required' => false, 'attr'=> array('data-prepend' => '$'), 'attr' => array('class' => 'form-control')))
			->add("annual", "text", array('label' => 'Annual', 'required' => false, 'attr'=> array('data-prepend' => '$'), 'attr' => array('class' => 'form-control')))
			->add("msetup", "text", array('label' => 'Monthly', 'required' => false, 'attr'=> array('data-prepend' => '$'), 'attr' => array('class' => 'form-control')))
			->add("qsetup", "text", array('label' => 'Monthly', 'required' => false, 'attr'=> array('data-prepend' => '$'), 'attr' => array('class' => 'form-control')))
			->add("ssetup", "text", array('label' => 'Monthly', 'required' => false, 'attr'=> array('data-prepend' => '$'), 'attr' => array('class' => 'form-control')))
			->add("asetup", "text", array('label' => 'Monthly', 'required' => false, 'attr'=> array('data-prepend' => '$'), 'attr' => array('class' => 'form-control')))
			->add("mdiscount", "text", array('label' => 'Monthly', 'required' => false, 'attr'=> array('data-append' => '%'), 'attr' => array('class' => 'form-control')))
			->add("qdiscount", "text", array('label' => 'Monthly', 'required' => false, 'attr'=> array('data-append' => '%'), 'attr' => array('class' => 'form-control')))
			->add("sdiscount", "text", array('label' => 'Monthly', 'required' => false, 'attr'=> array('data-append' => '%'), 'attr' => array('class' => 'form-control')))
			->add("adiscount", "text", array('label' => 'Monthly', 'required' => false, 'attr'=> array('data-append' => '%'), 'attr' => array('class' => 'form-control')))
        ;
    }

	/**
	 * @return string
	 */
	public function getName() {
        return 'product';
    }

	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\Product', 'id' => null);
    }

}
