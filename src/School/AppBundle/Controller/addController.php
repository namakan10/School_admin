<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 14/09/2018
 * Time: 10:47
 */

namespace School\AppBundle\Controller;


use School\AppBundle\Entity\Classes;
use School\AppBundle\Entity\Eleves;
use School\AppBundle\Entity\Parents;
use School\AppBundle\Entity\Payment;
use School\AppBundle\Entity\Payrecord;
use School\AppBundle\Entity\SpentRecord;
use School\AppBundle\Form\ClassesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class addController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addClassAction(Request $request){

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $repository = $this->getDoctrine()->getManager();

        $classes = new Classes();

        $form = $this->createForm(ClassesType::class, $classes);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);


            if ($form->isValid()) {

                if($form["numero"]->getData()<=0){
                    $error = "Numero de classe invalide, il doit être positif";
                    return $this->render('@SchoolApp/Class/addClass.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $this->getUser(),
                        'error' => $error,
                        'admin' => $admin,
                    ));
                }
                else if($form["capMax"]->getData()<=0){
                    $error = "Capacité Maximale de classe invalide, il doit être positif";
                    return $this->render('@SchoolApp/Class/addClass.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $this->getUser(),
                        'error' => $error,
                        'admin' => $admin,
                    ));
                }
                else{
                    $class = $repository->getRepository('SchoolAppBundle:Classes')->findBy(array(
                        'numero' => $form["numero"]->getData(),
                        'nom' => $form["nom"]->getData()
                    ));


                    if($class == null){

                        $repository->persist($classes);
                        $repository->flush();

                        return $this->redirectToRoute('school_app_class');
                    }

                    else{
                        $error = 'Cette classe existe déjà Avec le même numéro';
                        return $this->render('@SchoolApp/Class/addClass.html.twig', array(
                            'form' => $form->createView(),
                            'user' => $this->getUser(),
                            'error' => $error,
                            'year' => $year,
                            'definied' => $definied,
                            'admin' => $admin
                        ));

                    }
                }

            }

        }

        return $this->render('@SchoolApp/Class/addClass.html.twig',array(
            'user' => $this->getUser(),
            'form' => $form->createView(),
            'year' => $year,
            'definied' => $definied,
            'admin' => $admin,
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function inscriptionAction(Request $request){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];


        if ($definied == false){
            return $this->redirectToRoute('school_app_homepage');
        }

        $student  = array('text'=>'description');

        $inscrip = true;

        $repository = $this->getDoctrine()->getManager();

        $classes = $repository->getRepository('SchoolAppBundle:Classes')->findAll();

        $notclass = false;

        if ($classes == null){
            $notclass = true;
            return $this->render('@SchoolApp/Student/inscription_eleves.html.twig', array(
                'user' => $this->getUser(),
                'inscrip' => $inscrip,
                'definied' => $definied,
                'year' => $year,
                'admin' => $admin,
                'notclass' => $notclass,
            ));
        }

        $classroom =  array();

        foreach ($classes as $class){
            $classroom[$class->getNom()] = $class->getId();
        }


        $form = $this->createFormBuilder($student)
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom',
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('birthdate', DateType::class, array(
                'format' => 'dd-MM-yyyy',
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => array(
                    'placeholder' => 'jj-mm-aaaa'
                ),
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
            ->add('motherjob', TextType::class, array(
                'label' => 'Profession'
            ))
            ->add('fatheradresse', TextareaType::class, array(
                'label' => 'Adresse'
            ))
            ->add('Inscrire', SubmitType::class)
            ->getForm();

        if($request->isMethod('Post')){
            $form->handleRequest($request);

            if($form->isValid()){
                $classroom = $repository->getRepository('SchoolAppBundle:Classes')->findOneBy(array(
                    'id' => $form["classe"]->getData()
                ));
                if($classroom->getRegistration()>$form["pay"]->getData()){
                    $error = 'Le montant est inférieur au frais d inscription';
                    return $this->render('@SchoolApp/Student/inscription_eleves.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $this->getUser(),
                        'error' => $error,
                        'inscrip' => $inscrip,
                        'definied' => $definied,
                        'year' => $year,
                        'admin' => $admin,
                        'notclass' => $notclass,
                    ));
                }
                else{

                    $pay = new Payment();
                    $pay->setAmout($form["pay"]->getData());
                    $pay->setYear($year);
                    $repository->persist($pay);
                    $repository->flush();

                    $student = new Eleves();
                    $student->setPrenom($form["firstname"]->getData());
                    $student->setNom($form["lastname"]->getData());
                    $student->setBirthdate($form["birthdate"]->getData());
                    $student->setBirthplace($form["birthplace"]->getData());
                    $student->setClasses($classroom);
                    $student->setYear($year);
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
                    $student->setPay($pay);
                    $repository->persist($student);
                    $repository->flush();

                    $now = new \DateTime();
                    $record = new Payrecord();
                    $record->setAmout(40000);
                    $record->setMotif("Frais d'inscription");
                    $record->setDate($now);
                    $record->setYear($year);
                    $record->setStudent($student);
                    $repository->persist($record);
                    $repository->flush();

                    if(intval($form["pay"]->getData())-40000 == $classroom->getAnnual()){
                        $record = new Payrecord();
                        $record->setAmout(intval($form["pay"]->getData())-40000);
                        $record->setDate($now);
                        $record->setStudent($student);
                        $record->setMotif("Totatilité de l'année");
                        $record->setYear($year);
                        $repository->persist($record);
                        $repository->flush();
                    }
                    else if(intval($form["pay"]->getData())-40000 > 0){
                        $record = new Payrecord();
                        $record->setAmout(intval($form["pay"]->getData())-40000);
                        $record->setDate($now);
                        $record->setStudent($student);
                        $record->setMotif("Avance");
                        $record->setYear($year);
                        $repository->persist($record);
                        $repository->flush();
                    }


                    $father = new Parents();
                    $father->setName($form["fathername"]->getData());
                    $father->setLastname($form["lastname"]->getData());
                    $father->setAdresse($form["fatheradresse"]->getData());
                    $father->setJob($form["fatherjob"]->getData());
                    $father->setPhone($form["fatherphone"]->getData());
                    $father->setGenre("male");
                    $father->setStudent($student);
                    $repository->persist($father);
                    $repository->flush();

                    $mother = new Parents();
                    $mother->setName($form["mothername"]->getData());
                    $mother->setLastname($form["motherlastname"]->getData());
                    $mother->setJob($form["motherjob"]->getData());
                    $mother->setPhone($form["motherphone"]->getData());
                    $mother->setGenre("female");
                    $mother->setStudent($student);
                    $repository->persist($mother);
                    $repository->flush();


                    return $this->redirectToRoute('school_app_details_class', array(
                        'id' => $student->getId(),
                    ));

                }
            }
        }

        return $this->render('@SchoolApp/Student/inscription_eleves.html.twig', array(
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'inscrip' => $inscrip,
            'definied' => $definied,
            'year' => $year,
            'admin' => $admin,
            'notclass' => $notclass,
        ));
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newPaymentAction($id, Request $request){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];
        $repository = $this->getDoctrine()->getManager();

        $std = $repository->getRepository('SchoolAppBundle:Eleves')->find($id);
        $class  = $repository->getRepository('SchoolAppBundle:Classes')->find($std->getClasses());
        $pay = $repository->getRepository('SchoolAppBundle:Payment')->find($std->getPay());

        $data = array('name' => 'list');

        $form = $this->createFormBuilder($data)
            ->add('Motif', TextType::class)
            ->add('Montant', IntegerType::class)
            ->add('Classe', TextType::class, array(
                'disabled' => true,
                'data' => $class->getNom(),
            ))
            ->add('stdname', TextType::class, array(
                'label' => 'Prénom',
                'disabled' => true,
                'data' => $std->getPrenom(),
            ))
            ->add('stdlastname', TextType::class, array(
                'label' => 'Nom',
                'disabled' => true,
                'data' => $std->getNom(),
            ))
            ->add('Submit', SubmitType::class, array(
                'label' => 'Valider'
            ))
            ->getForm();

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid()){

                if($form["Montant"]->getData()<=0){
                    $error = 'Veuillez saisir un montant strictement positif';
                    return $this->render('@SchoolApp/Payemnt/newPayement.html.twig', array(
                        'user' => $this->getUser(),
                        'definied' => $definied,
                        'year' => $year,
                        'form' => $form->createView(),
                        'error' => $error,
                        'id' => $id,
                        'admin' => $admin,
                    ));
                }
                else{
                    $pay->setAmout($pay->getAmout()+$form["Montant"]->getData());
                    $repository->persist($pay);
                    $repository->flush();

                    $record = new Payrecord();

                    $record->setAmout($form["Montant"]->getData());
                    $record->setYear($year);
                    $record->setMotif($form["Motif"]->getData());
                    $record->setStudent($std);
                    $record->setDate(new \DateTime());
                    $repository->persist($record);

                    $repository->flush();

                    $id = intval($std->getId());

                    return $this->redirectToRoute('school_app_sudent_details', array(
                        'id' => $id
                    ));

                }
            }
        }

        return $this->render('@SchoolApp/Payemnt/newPayement.html.twig', array(
            'user' => $this->getUser(),
            'definied' => $definied,
            'year' => $year,
            'form' => $form->createView(),
            'id' => $id,
            'admin' => $admin,
        ));

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newExitAction(Request $request){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        $repository = $this->getDoctrine()->getManager();
        $cash = $repository->getRepository('SchoolAppBundle:CashRegister')->findOneBy(array(
            'year' => $year,
        ));

        $data = array('name' => 'lise');

        $form = $this->createFormBuilder($data)
            ->add('motive', TextareaType::class, array(
                'label' => 'Motif'
            ))
            ->add('amout', IntegerType::class, array(
                'label' => 'Montant'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider',
            ))
            ->getForm();

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isValid()){
                if($form["amout"]->getData()<=0){
                    $error = "Veuillez saisir un montant scritement positif";
                    return $this->render('@SchoolApp/Caisse/newExit.html.twig', array(
                        'user' => $this->getUser(),
                        'year' => $year,
                        'definied' => $definied,
                        'form' => $form->createView(),
                        'error' => $error,
                        'admin' => $admin,
                    ));

                }
                else{
                    $record = new SpentRecord();
                    $record->setMotive($form["motive"]->getData());
                    $record->setAmout($form["amout"]->getData());
                    $record->setCashregister($cash);

                    $repository->persist($record);
                    $repository->flush();

                    return $this->redirectToRoute('cashRegister_record');

                }
            }
        }

        return $this->render('@SchoolApp/Caisse/newExit.html.twig', array(
            'user' => $this->getUser(),
            'year' => $year,
            'definied' => $definied,
            'form' => $form->createView(),
            'admin' => $admin,
        ));
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateExitAction($id, Request $request){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        $repository = $this->getDoctrine()->getManager();
        $record = $repository->getRepository('SchoolAppBundle:SpentRecord')->find($id);

        $data = array('name' => 'lise');

        $form = $this->createFormBuilder($data)
            ->add('motive', TextareaType::class, array(
                'label' => 'Motif',
                'data' => $record->getMotive(),
            ))
            ->add('amout', IntegerType::class, array(
                'label' => 'Montant',
                'data' => $record->getAmout(),
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider',
            ))
            ->getForm();

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isValid()){
                if($form["amout"]->getData()<=0){
                    $error = "Veuillez saisir un montant scritement positif";
                    return $this->render('@SchoolApp/Caisse/editExit.html.twig', array(
                        'user' => $this->getUser(),
                        'year' => $year,
                        'definied' => $definied,
                        'form' => $form->createView(),
                        'update' => $error,
                        'record' => $record,
                        'admin' => $admin,
                    ));

                }
                else{

                    $record->setMotive($form["motive"]->getData());
                    $record->setAmout($form["amout"]->getData());
                    $repository->persist($record);
                    $repository->flush();

                    return $this->render('@SchoolApp/Caisse/editExit.html.twig', array(
                        'user' => $this->getUser(),
                        'year' => $year,
                        'definied' => $definied,
                        'form' => $form->createView(),
                        'update' => "Modification effectué avec succès",
                        'record' => $record,
                        'admin' => $admin,
                    ));
                }
            }
        }
        return $this->render('@SchoolApp/Caisse/editExit.html.twig', array(
            'user' => $this->getUser(),
            'year' => $year,
            'definied' => $definied,
            'form' => $form->createView(),
            'record' => $record,
            'admin' => $admin,
        ));
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateClasseAction($id, Request $request){
        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $repository = $this->getDoctrine()->getManager();

        $classes = $repository->getRepository('SchoolAppBundle:Classes')->find($id);

        $form = $this->createForm(ClassesType::class, $classes);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);


            if ($form->isValid()) {

                if($form["numero"]->getData()<=0){
                    $error = "Numero de classe invalide, il doit être positif";
                    return $this->render('@SchoolApp/Class/edit_class.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $this->getUser(),
                        'error' => $error,
                        'admin' => $admin,
                    ));
                }
                else if($form["capMax"]->getData()<=0){
                    $error = "Capacité Maximale de classe invalide, il doit être positif";
                    return $this->render('@SchoolApp/Class/edit_class.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $this->getUser(),
                        'error' => $error,
                        'admin' => $admin,
                    ));
                }
                else{
                    $class = $repository->getRepository('SchoolAppBundle:Classes')->findOneBy(array(
                        'numero' => $form["numero"]->getData(),
                        'nom' => $form["nom"]->getData()
                    ));


                    if($class == null OR $class->getId() == $classes->getId()){

                        $repository->persist($classes);
                        $repository->flush();

                        $error = 'Mise à jour effectuée avec succès !';

                        return $this->render('@SchoolApp/Class/edit_class.html.twig', array(
                            'form' => $form->createView(),
                            'user' => $this->getUser(),
                            'error' => $error,
                            'year' => $year,
                            'definied' => $definied,
                            'admin' => $admin
                        ));
                    }

                    else{
                        $error = 'Cette classe existe déjà Avec le même numéro';
                        return $this->render('@SchoolApp/Class/edit_class.html.twig', array(
                            'form' => $form->createView(),
                            'user' => $this->getUser(),
                            'error' => $error,
                            'year' => $year,
                            'definied' => $definied,
                            'admin' => $admin
                        ));
                    }
                }
            }
        }

        return $this->render('@SchoolApp/Class/edit_class.html.twig',array(
            'user' => $this->getUser(),
            'form' => $form->createView(),
            'year' => $year,
            'definied' => $definied,
            'admin' => $admin,
        ));
    }


    public function updatePayementAction($id, Request $request){

    }

}