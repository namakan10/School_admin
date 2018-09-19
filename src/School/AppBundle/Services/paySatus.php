<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 14/09/2018
 * Time: 15:17
 */

namespace School\AppBundle\Services;

use Doctrine\ORM\EntityManager;
use School\AppBundle\Entity\User;

class paySatus
{
    private $em = null;

    /**
     * paySatus constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $id
     * @param $year
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function status($id, $year){

        $classes = $this->em->getRepository('SchoolAppBundle:Classes')->findOneBy(array(
            'id' => $id,
        ));

        $student = $this->em->getRepository('SchoolAppBundle:Eleves')->findBy(array(
            'classes' => $id,
            'year' => $year,
        ), array(
            'nom' => 'asc'
        ));


        $now = new \DateTime();
        $now_month = $now->format('m');
        $now_month = intval($now_month);
        $now_days = intval($now->format('d'));

        $require = null;


        foreach ($student as $std){

            $pay = $this->em->getRepository('SchoolAppBundle:Payment')->find($std->getPay());
            $solde = $pay->getAmout() - $classes->getRegistration();



            if ($now_month <= 10 AND $now_month > 7){
                if($solde > 0){
                    $std->setStatus("En avance");
                }
                else{
                    $std->setStatus("A jour");
                }
            }
            else{
                if ($now_month == 11){
                    $require  = $classes->getAnnual()/9;

                }
                else if($now_month == 12){
                    $require = $classes->getAnnual()/8;
                }
                else if ($now_month == 1){
                    $require = $classes->getAnnual()/7;
                }
                else if($now_month == 2){
                    $require =$classes->getAnnual()/6;
                }
                else if ($now_month == 3){
                    $require =$classes->getAnnual()/5;
                }
                else if ($now_month == 4){
                    $require =$classes->getAnnual()/4;
                }
                else if($now_month == 5){
                    $require =$classes->getAnnual()/3;
                }
                else if($now_month == 6){
                    $require =$classes->getAnnual()/2;
                }
                else if ($now_month == 7){
                    $require =$classes->getAnnual();
                }

                if ($now_days>5){
                    if($solde<$require){
                        $std->setStatus("En retard");
                    }
                    else if ($solde=$require){
                        $std->setStatus("A jour");
                    }
                    else{
                        $std->setStatus("En avance");
                    }
                }
                else{
                    if($solde > 0){
                        $std->setStatus("En avance");
                    }
                    else{
                        $std->setStatus("A jour");
                    }
                }
            }

            if($solde == $classes->getAnnual()){
                $std->setStatus("Achevé");
            }


            $this->em->persist($std);
            $this->em->flush();
        }

        return true;

    }
}