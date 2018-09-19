<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 14/09/2018
 * Time: 11:07
 */

namespace School\AppBundle\Controller;


use School\AppBundle\Entity\Classes;
use School\AppBundle\Entity\Eleves;
use School\AppBundle\Entity\Parents;
use School\AppBundle\Entity\Payment;
use School\AppBundle\Entity\Payrecord;
use School\AppBundle\Form\ClassesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class detailsviewController extends Controller
{
    public function studentdetailsAction($id, Request $request){

        $notclass = false;
        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }


        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];


        $description  = array('text'=>'description');
        $repository = $this->getDoctrine()->getManager();

        $classes = $repository->getRepository('SchoolAppBundle:Classes')->findAll();



        $student = $repository->getRepository('SchoolAppBundle:Eleves')->find($id);

        $classstd = $repository->getRepository('SchoolAppBundle:Classes')->find($student->getClasses());

        $classroom =  array();

        $classroom[$classstd->getNom()] = $classstd->getId();
        foreach ($classes as $class){
            $classroom[$class->getNom()] = $class->getId();
        }

        $pay = $repository->getRepository('SchoolAppBundle:Payment')->find($student->getPay());

        $father = $repository->getRepository('SchoolAppBundle:Parents')->findOneBy(array(
            'student' => $student,
            'genre' => 'male'
        ));

        $mother = $repository->getRepository('SchoolAppBundle:Parents')->findOneBy(array(
            'student' => $student,
            'genre' => 'female'
        ));

        if($admin == true){
            $form = $this->createFormBuilder($description)
                ->add('firstname', TextType::class, array(
                    'label' => 'Prénom',
                    'data' => $student->getPrenom(),
                ))
                ->add('lastname', TextType::class, array(
                    'label' => 'Nom',
                    'data' => $student->getNom(),
                ))
                ->add('birthdate', DateType::class, array(
                    'format' => 'dd-MM-yyyy',
                    'label' => 'Date de naissance',
                    'widget' => 'single_text',
                    'data' => $student->getBirthdate(),

                ))
                ->add('birthplace', TextType::class, array(
                    'label' => 'Lieu de naissance',
                    'data' => $student->getBirthplace(),
                ))
                ->add('classe', ChoiceType::class, array(
                    'choices' => $classroom,
                ))
                ->add('pay', IntegerType::class, array(
                    'label' => 'Montant payé',
                    'data' => $pay->getAmout(),
                    'disabled' => true,
                ))
                ->add('fathername', TextType::class, array(
                    'label' => 'Prénom',
                    'data' => $father->getName(),
                ))
                ->add('fatherphone', TextType::class, array(
                    'label' => 'Numéro de téléphone',
                    'data' => $father->getPhone(),
                ))
                ->add('fatherjob', TextType::class, array(
                    'label' => 'Profession',
                    'data' => $father->getJob(),
                ))
                ->add('mothername', TextType::class, array(
                    'label' => 'Prénom',
                    'data' => $mother->getName(),
                ))
                ->add('motherlastname', TextType::class, array(
                    'label' => 'Nom',
                    'data' => $mother->getLastname(),
                ))
                ->add('motherphone', TextType::class, array(
                    'label' => 'Numéro de téléphone',
                    'data' => $mother->getPhone(),
                ))
                ->add('motherjob', TextType::class, array(
                    'label' => 'Profession',
                    'data' => $mother->getJob(),
                ))
                ->add('fatheradresse', TextareaType::class, array(
                    'label' => 'Adresse',
                    'data' => $father->getAdresse(),
                ))
                ->add('Inscrire', SubmitType::class, array(
                    'label' => 'Mettre à jour'
                ))
                ->getForm();
        }
        else{
            $form = $this->createFormBuilder($description)
                ->add('firstname', TextType::class, array(
                    'label' => 'Prénom',
                    'data' => $student->getPrenom(),
                    'disabled' => true,
                ))
                ->add('lastname', TextType::class, array(
                    'label' => 'Nom',
                    'data' => $student->getNom(),
                    'disabled' => true,
                ))
                ->add('birthdate', DateType::class, array(
                    'format' => 'dd-MM-yyyy',
                    'label' => 'Date de naissance',
                    'widget' => 'single_text',
                    'data' => $student->getBirthdate(),
                    'disabled' => true,

                ))
                ->add('birthplace', TextType::class, array(
                    'label' => 'Lieu de naissance',
                    'data' => $student->getBirthplace(),
                    'disabled' => true,
                ))
                ->add('classe', ChoiceType::class, array(
                    'choices' => $classroom,
                    'disabled' => true,
                ))
                ->add('pay', IntegerType::class, array(
                    'label' => 'Montant payé',
                    'data' => $pay->getAmout(),
                    'disabled' => true,
                ))
                ->add('fathername', TextType::class, array(
                    'label' => 'Prénom',
                    'data' => $father->getName(),
                    'disabled' => true,
                ))
                ->add('fatherphone', TextType::class, array(
                    'label' => 'Numéro de téléphone',
                    'data' => $father->getPhone(),
                    'disabled' => true,
                ))
                ->add('fatherjob', TextType::class, array(
                    'label' => 'Profession',
                    'data' => $father->getJob(),
                    'disabled' => true,
                ))
                ->add('mothername', TextType::class, array(
                    'label' => 'Prénom',
                    'data' => $mother->getName(),
                    'disabled' => true,
                ))
                ->add('motherlastname', TextType::class, array(
                    'label' => 'Nom',
                    'data' => $mother->getLastname(),
                    'disabled' => true,
                ))
                ->add('motherphone', TextType::class, array(
                    'label' => 'Numéro de téléphone',
                    'data' => $mother->getPhone(),
                    'disabled' => true,
                ))
                ->add('motherjob', TextType::class, array(
                    'label' => 'Profession',
                    'data' => $mother->getJob(),
                    'disabled' => true,
                ))
                ->add('fatheradresse', TextareaType::class, array(
                    'label' => 'Adresse',
                    'data' => $father->getAdresse(),
                    'disabled' => true,
                ))
                ->add('Inscrire', SubmitType::class, array(
                    'label' => 'Mettre à jour',
                    'disabled' => true,
                ))
                ->getForm();
        }


        if($request->isMethod('Post')){
            $form->handleRequest($request);

            if($form->isValid()){
                $classroom = $repository->getRepository('SchoolAppBundle:Classes')->findOneBy(array(
                    'id' => $form["classe"]->getData()
                ));
                if($classroom->getRegistration()>$form["pay"]->getData()){
                    $error = "Le montant est inférieur au frais d'inscription";
                    return $this->render('@SchoolApp/Student/inscription_eleves.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $this->getUser(),
                        'error' => $error,
                        'definied' => $definied,
                        'year' => $year,
                        'admin' => $admin,
                        'notclass' => $notclass,
                    ));
                }
                else{



                    $update = false;
                    if($form["firstname"]->getData() != $student->getPrenom() OR $form["lastname"]->getData() != $student->getNom() OR $form["classe"] != $student->getClasses()){
                        $update = true;
                    }

                    $student->setPrenom($form["firstname"]->getData());
                    $student->setNom($form["lastname"]->getData());
                    $student->setBirthdate($form["birthdate"]->getData());
                    $student->setBirthplace($form["birthplace"]->getData());
                    $student->setClasses($classroom);

                    if($update == true){

                        $mat = $this->container->get('add_student')->matricule($classroom, $form["firstname"]->getData(), $form["lastname"]->getData(), 5);

                        $check = $repository->getRepository('SchoolAppBundle:Eleves')->findOneBy(array(
                            'matricule' => $mat
                        ));

                        while($check != null){

                            $mat = $this->container->get('add_student')->matricule($classroom, $form["firstname"]->getData(), $form["lastname"]->getData(), 10);
                            $check = $repository->getRepository('SchoolAppBundle:Eleves')->findOneBy(array(
                                'matricule' => $mat
                            ));
                        }

                        $student->setMatricule($mat);
                    }




                    $repository->persist($student);
                    $repository->flush();



                    $pay->setAmout($form["pay"]->getData());
                    $pay->setStudent($student);
                    $repository->persist($pay);
                    $repository->flush();



                    $father->setName($form["fathername"]->getData());
                    $father->setLastname($form["lastname"]->getData());
                    $father->setAdresse($form["fatheradresse"]->getData());
                    $father->setJob($form["fatherjob"]->getData());
                    $father->setPhone($form["fatherphone"]->getData());
                    $father->setGenre("male");
                    $father->setStudent($student);
                    $repository->persist($father);
                    $repository->flush();


                    $mother->setName($form["mothername"]->getData());
                    $mother->setLastname($form["motherlastname"]->getData());
                    $mother->setJob($form["motherjob"]->getData());
                    $mother->setPhone($form["motherphone"]->getData());
                    $mother->setGenre("female");
                    $mother->setStudent($student);
                    $repository->persist($mother);
                    $repository->flush();

                    $inscrip = false;

                    return $this->render('@SchoolApp/Student/studentdetails.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $this->getUser(),
                        'class' => $classstd,
                        'inscrip' => $inscrip,
                        'definied' => $definied,
                        'year' => $year,
                        'id' => $id,
                        'error' => "Mise à jour effectuée avec succes",
                        'admin' => $admin,
                        'notclass' => $notclass,
                    ));

                }
            }
        }

        $inscrip = false;
        return $this->render('@SchoolApp/Student/studentdetails.html.twig', array(
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'class' => $classstd,
            'inscrip' => $inscrip,
            'definied' => $definied,
            'year' => $year,
            'id' => $id,
            'admin' => $admin,
            'notclass' => $notclass,
        ));
    }
}