<?php

namespace School\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', IntegerType::class, array(
                'label' => 'Numéro'
            ))
            ->add('nom', TextType::class, array(
                'label' => 'Nom de la classe'
            ))
            ->add('capMax', IntegerType::class, array(
                'label' => 'Capacité Maximale'
            ))
            ->add('level', ChoiceType::class, array(
                'label' => 'Niveau',
                'choices' => array(
                    'Prémier Cycle' => 'Prémier Cycle',
                    'Second Cycle' =>'Second Cycle',
                )
            ))
            ->add('registration', IntegerType::class, array(
                'label' => "Frais d'insciption"
            ))
            ->add('annual', IntegerType::class, array(
                'label' => "Frais annuelle"
            ))
            ->add('Creer', SubmitType::class
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\AppBundle\Entity\Classes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'school_appbundle_classes';
    }


}
