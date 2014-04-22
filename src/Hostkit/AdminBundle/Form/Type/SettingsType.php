<?php



namespace Hostkit\AdminBundle\Form\Type;



use Symfony\Component\Form\AbstractType, 
	Symfony\Component\Form\FormBuilderInterface, 
	Symfony\Component\HttpFoundation\Request, 
	Hostkit\AdminBundle\Form\Type\PaymentType,
	Doctrine\ORM\EntityRepository;

use Hostkit\CoreBundle\Entity\Settings;


/**
 * Class SettingsType
 * @package Hostkit\AdminBundle\Form\Type
 */
class SettingsType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
			//->add('payment', new PaymentType())
			->add("companyName", "text", array('label' => 'Company Name', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('companyAddress1', 'text', array('label' => 'Address', 'required' => true, 'attr' => array('class' => 'form-control')))
			->add('companyPostcode', 'text', array('label' => 'Areacode', 'required' => true, 'attr' => array('class' => 'form-control')))
			->add('companyCity', 'text', array('label' => 'City', 'required' => true, 'attr' => array('class' => 'form-control')))
			->add('companyCountry', 'text', array('label' => 'Country', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('companyState', 'text', array('label' => 'State', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add('companyOwner', 'text', array('label' => 'Owner', 'required' => true, 'attr' => array('class' => 'form-control')))
			->add('companyPhone', 'text', array('label' => 'Phone', 'required' => false, 'attr' => array('class' => 'form-control')))
			->add('companyEmail', 'text', array('label' => 'Company E-Mail', 'required' => true, 'attr' => array('class' => 'form-control')))
			->add('supportEmail', 'text', array('label' => 'Support E-Mail', 'required' => true, 'attr' => array('class' => 'form-control')))
			->add('logo', 'file', array('label' => 'Logo', 'required' => false, 'attr' => array('style' => 'padding: 0;', 'class' => 'form-control')))
			->add('facebook', 'url', array('label' => 'Facebook Url', 'required' => false, 'attr' => array('class' => 'form-control')))
			->add('twitter', 'url', array('label' => 'Twitter Url', 'required' => false, 'attr' => array('class' => 'form-control')))
			->add('google', 'url', array('label' => 'Google+ Url', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('signature', 'textarea', array('label' => 'E-Mail Signature', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('terms_conditions', 'textarea', array('label' => 'Terms & Conditions', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('autoJobsDomains', 'checkbox', array('label' => 'Autojobs DomainHosting', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('autoJobsHosting', 'checkbox', array('label' => 'Autojobs Hosting', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('domainReseller', 'text', array('label' => 'Reseller ID', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('domainPassword', 'text', array('label' => 'Password', 'required' => false, 'attr' => array('class' => 'form-control')))
			->add('UStID', 'text', array('label' => 'UStID (Germany)', 'required' => false, 'attr' => array('class' => 'form-control')))

        ;
    }


	/**
	 * @return string
	 */
	public function getName() {
        return 'settings';
    }


	/**
	 * @param array $options
	 *
	 * @return array
	 */public function getDefaultOptions(array $options) {
        return array('data_class' => 'Hostkit\CoreBundle\Entity\Settings', 'id' => null);
    }



}

