<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 14/09/2018
 * Time: 11:05
 */

namespace School\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class listviewController extends Controller
{
    public function classAction(){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        $repository = $this->getDoctrine()->getManager();
        $classes = $repository->getRepository('SchoolAppBundle:Classes')->findBy(array(), array(
            'nom' => 'asc'
        ));

        foreach ($classes as $class){
            $student  = $repository->getRepository('SchoolAppBundle:Eleves')->findBy(array(
                'classes' => $class
            ));
            $comp = 0;

            foreach ($student as $std){
                $comp++;
            }
            $class->setCapNow($comp);
            $repository->persist($class);
            $repository->flush();
        }

        return $this->render('@SchoolApp/Class/classes.html.twig', array(
            'user' => $this->getUser(),
            'classes' => $classes,
            'definied' => $definied,
            'year' => $year,
            'admin' => $admin,
        ));
    }

    public function detailsclassAction($id){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        $repository = $this->getDoctrine()->getManager();

        $data = $this->container->get('payStatus')->status($id, $year);

        $classes = $repository->getRepository('SchoolAppBundle:Classes')->findOneBy(array(
            'id' => $id,
        ));

        $student = $repository->getRepository('SchoolAppBundle:Eleves')->findBy(array(
            'classes' => $id,
            'year' => $year,
        ), array(
            'nom' => 'asc'
        ));


        return $this->render('@SchoolApp/Class/detailsClass.html.twig', array(
            'user' => $this->getUser(),
            'student' => $student,
            'classes' => $classes,
            'year' => $year,
            'definied' => $definied,
            'classdetails' => true,
            'admin' => $admin,
        ));

    }

    public function paystudentlistAction($id){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        $repository = $this->getDoctrine()->getManager();
        $classes = $repository->getRepository('SchoolAppBundle:Classes')->findOneBy(array(
            'id' => $id,
        ));

        $student = $repository->getRepository('SchoolAppBundle:Eleves')->findBy(array(
            'classes' => $id,
            'year' => $year,
        ), array(
            'nom' => 'asc'
        ));


        return $this->render('@SchoolApp/Payemnt/newPayement.html.twig', array(
            'user' => $this->getUser(),
            'student' => $student,
            'classes' => $classes,
            'year' => $year,
            'definied' => $definied,
            'classdetails' => false,
            'admin' => $admin,
        ));
    }

    public function payrecordAction($id){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $repository = $this->getDoctrine()->getManager();

        $std = $repository->getRepository('SchoolAppBundle:Eleves')->find($id);

        $record = $repository->getRepository('SchoolAppBundle:Payrecord')->findBy(array(
            'student' => $std
        ), array(
           'date' => 'asc'
        ));

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        return $this->render('@SchoolApp/Payemnt/payRecord.html.twig', array(
            'id' => $id,
            'std' => $std,
            'record' => $record,
            'user' => $this->getUser(),
            'year' => $year,
            'definied' => $definied,
            'admin' => $admin,
        ));
    }

    public function caiseviewAction(){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }


        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        $data = $this->container->get('cashRegister')->cashData($year);
        $cash = $data["cash"];
        $record = $data["record"];
        $avialable = $data["avialable"];
        $exit = $data["exit"];
        $enter = $data["enter"];



        return $this->render('@SchoolApp/Caisse/caiseview.html.twig', array(
            'definied' => $definied,
            'year' => $year,
            'user' => $this->getUser(),
            'cash' => $cash,
            'record' => $record,
            'avialable' => $avialable,
            'enter' => $enter,
            'exit' => $exit,
            'admin' => $admin,
        ));
    }

    public function cashRegisterRecordAction(){

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];
        $data = $this->container->get('cashRegister')->cashData($year);
        $cash = $data["cash"];
        $record = $data["record"];

        return $this->render('@SchoolApp/Caisse/cashRegisterRecord.html.twig', array(
            'definied' => $definied,
            'year' => $year,
            'user' => $this->getUser(),
            'cash' => $cash,
            'record' => $record,
            'admin' => $admin,
        ));


    }
}