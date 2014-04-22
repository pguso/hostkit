<?php

namespace Hostkit\EmailBundle\Form\Type;

use Symfony\Component\Form\AbstractType, Symfony\Component\Form\FormBuilderInterface, Symfony\Component\HttpFoundation\Request, Doctrine\ORM\EntityRepository;
use Hostkit\CoreBundle\Entity\Email;

class EmailType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $emailId = 31;

        if(array_key_exists('emailId', $options['attr'])) {
            $emailId = $options['attr']['emailId'];
        }

        $builder
            ->add("name", "text", array('label' => 'Template Name', 'required' => true, 'read_only' => ($emailId < 30 ? true : false), 'attr' => array('class' => 'form-control')))
            ->add("subject", "text", array('label' => 'Subject', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("contentTop", "textarea", array('label' => 'Content Top', 'required' => true, 'attr' => array('style' => 'min-height: 300px;', 'class' => 'form-control')))
            ->add('contentInner', 'textarea', array('label' => 'Content Inner', 'required' => false, 'attr' => array('class' => 'form-control')))

        ;
    }

    public function getName() {
        return 'email';
    }

}