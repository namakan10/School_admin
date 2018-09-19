<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 16/09/2018
 * Time: 13:56
 */

namespace School\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class removeController extends Controller
{
    public function removeStudentAction($id){

        $repository = $this->getDoctrine()->getManager();
        $sudent = $repository->getRepository('SchoolAppBundle:Eleves')->find($id);
        $id = $repository->getRepository('SchoolAppBundle:Classes')->find($sudent->getClasses());
        $id=  intval($id->getId());

        $payment = $repository->getRepository('SchoolAppBundle:Payment')->find($sudent->getPay());

        $record = $repository->getRepository('SchoolAppBundle:Payrecord')->findBy(array(
            'student' => $sudent
        ));


        $repository->remove($sudent);
        $repository->remove($payment);
        foreach ($record as $rec){
            $repository->remove($rec);
        }

        $repository->flush();



        return $this->redirectToRoute('school_app_details_class', array(
            'id' => $id
        ));
    }

    public function removeExitRecordAction($id){

        $repository = $this->getDoctrine()->getManager();

        $record = $repository->getRepository('SchoolAppBundle:SpentRecord')->find($id);

        $repository->remove($record);
        $repository->flush();

        return $this->redirectToRoute('cashRegister_record');
    }

    public function removeClassAction($id){

        $repository = $this->getDoctrine()->getManager();

        $class = $repository->getRepository('SchoolAppBundle:Classes')->find($id);

        $repository->remove($class);
        $repository->flush();

        return $this->redirectToRoute('school_app_class');

    }
}