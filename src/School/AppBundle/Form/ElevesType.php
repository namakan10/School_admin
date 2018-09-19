<?php

namespace School\AppBundle\Form;

use School\AppBundle\Entity\Classes;
use School\AppBundle\Entity\Parents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElevesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('birthdate', DateType::class, array(
                'label' => 'Date de naissance'
            ))
            ->add('birthplace', TextType::class, array(
                'label' => 'Lieu de naissance'
            ))
            ->add('classes', CollectionType::class, array(
                'entry_type' => ClassesType::class,
                'allow_add' => true
            ))
            ->add('Parents', Parents::class)
            ->add('pay', PaymentType::class, array(
                'label' => 'Montant payé'
            ))

            ->add('Inscrire', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\AppBundle\Entity\Eleves'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'school_appbundle_eleves';
    }


}
