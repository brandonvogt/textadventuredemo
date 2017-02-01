<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserInputType extends AbstractType
{
  public function buildForm( FormBuilderInterface $builder, array $options )
  {
    $builder->add( 'input', TextType::class, array('label' => '> ', 'required' => false) );
  }

  function getName() {
    return 'UserInputType';
  }
}