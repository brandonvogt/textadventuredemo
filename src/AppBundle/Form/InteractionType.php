<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InteractionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('input')
                ->add('output')
                ->add('place', EntityType::class, array(
                    'label' => 'Current Place',
                    'class' => 'AppBundle:Place',
                    'choice_label' => function ($obj) {
                        return $obj->getId() . ' - ' . $obj->getTitle();},
                    'choice_value' => 'id',
                    'placeholder' => 'Please choose',
                    'empty_data'  => null))
                ->add('logic_flag')->add('item', null, array('required' => false))
                ->add('update_place', null, array('required' => false))
                
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Interaction'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_interaction';
    }


}
