<?php

namespace Hostkit\EmailBundle\Form\Type;

use Symfony\Component\Form\AbstractType, Symfony\Component\Form\FormBuilderInterface, Symfony\Component\HttpFoundation\Request, Doctrine\ORM\EntityRepository;
use Hostkit\CoreBundle\Entity\Email;

class EmailCustomType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add("subject", "text", array('label' => 'Subject', 'required' => true, 'attr' => array('class' => 'form-control')))
            ->add("contentTop", "textarea", array('label' => 'Message', 'required' => true, 'attr' => array('style' => 'min-height: 300px;', 'class' => 'form-control')))
            ->add('contentInner', 'textarea', array('label' => 'Notice Box', 'required' => false, 'attr' => array('class' => 'form-control')))

        ;
    }

    public function getName() {
        return 'email';
    }

}