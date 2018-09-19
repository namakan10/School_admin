<?php

namespace School\AppBundle\Controller;

use School\AppBundle\Entity\Classes;
use School\AppBundle\Entity\Eleves;
use School\AppBundle\Entity\Parents;
use School\AppBundle\Entity\Payment;
use School\AppBundle\Entity\Year;
use School\AppBundle\Form\ClassesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $admin =false;
        if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $admin = true;
        }

        $checkYear = $this->container->get('checkYear')->yearActive();
        $year = $checkYear["year"];
        $definied = $checkYear["definied"];

        $repository = $this->getDoctrine()->getManager();


        if ($definied == false){
            $data = array('list' => 'product');
            $form = $this->createFormBuilder($data)
                ->add('Year', ChoiceType::class, array(
                    'choices' => array(
                        "2018-2019" => "2018-2019",
                        "2019-2020" => "2019-2020",
                        "2020-2021" => "2020-2021",
                    )
                ))
                ->add('create', SubmitType::class, array(
                    'label' => 'Créer'
                ))
                ->getForm();

                if ($request->isMethod('POST')){
                    $form -> handleRequest($request);
                    if($form->isValid()){
                        $year = new Year();
                        $year->setStatus(true);
                        $year->setYear($form["Year"]->getData());
                        $repository->persist($year);
                        $repository->flush();

                        return $this->redirectToRoute('school_app_homepage');

                    }
                }

                return $this->render('@SchoolApp/Default/index.html.twig', array(
                    'user' => $this->getUser(),
                    'form' => $form->createView(),
                    'year' => $year,
                    'admin' => $admin,
                    'definied' => $definied,
                ));
        }

        return $this->render('SchoolAppBundle:Default:index.html.twig', array(
            'user' => $this->getUser(),
            'admin' => $admin,
            'definied' => $definied,
            'year' => $year,
        ));
    }

}
