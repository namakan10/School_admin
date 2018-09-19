<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 07/09/2018
 * Time: 18:27
 */

namespace School\AppBundle\Services;

use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;

class addStudent
{

    private $manager = null;

    public function __construct(EntityManager $manager) {
        $this->manager = $manager;
    }

    /*public function Form(){

        $classes = $this->manager->getRepository('SchoolAppBundle:Classes')->findAll();

        $classroom =  array();

        foreach ($classes as $class){
            $classroom[$class->getNom()] = $class->getId();
        }

        $student  = array('text'=>'description');

        $form = $this->em->createFormBuilder($student)
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('birthdate', TextType::class, array(
                'label' => 'Date de naissance'
            ))
            ->add('birthplace', TextType::class, array(
                'label' => 'Lieu de naissance'
            ))
            ->add('classe', ChoiceType::class, array(

                'choices' => $classroom
            ))
            ->add('pay', IntegerType::class, array(
                'label' => 'Prémier payement'
            ))
            ->add('fathername', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('fatherlastname', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('fatherphone', TextType::class, array(
                'label' => 'Numéro de téléphone'
            ))
            ->add('fatherjob', TextType::class, array(
                'label' => 'Profession'
            ))
            ->add('mothername', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('motherlastname', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('motherphone', TextType::class, array(
                'label' => 'Numéro de téléphone'
            ))
            ->add('montherjob', TextType::class, array(
                'label' => 'Profession'
            ))
            ->add('fatheadresse', TextareaType::class, array(
                'label' => 'Adresse'
            ))
            ->add('Inscrire', SubmitType::class)
            ->getForm();


        return $form;
    }*/

    public function matricule($class, $fisrtname, $lastname, $lenght){

        $mat = "";
        $chaine = "0123456789";

        srand((double)microtime()*1000000);

        while($lenght!=0){
            $mat .= $chaine[rand()%strlen($chaine)];
            $lenght--;
        }


        $mat = "EMC".$class->getNom()[0]."-".$fisrtname[0].$mat.$lastname[0];

        return $mat;
    }
}