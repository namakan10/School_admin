<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 17/09/2018
 * Time: 09:29
 */

namespace School\AppBundle\Services;


use Doctrine\ORM\EntityManager;
use School\AppBundle\Entity\CashRegister;

class cashRegisterServices
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function cashData($year){

        $payment = $this->em->getRepository('SchoolAppBundle:Payment')->findBy(array(
            'year' => $year
        ));

        $total = 0;
        foreach ($payment as $pay){
            $total += $pay->getAmout();
        }

        $cash = $this->em->getRepository('SchoolAppBundle:CashRegister')->findOneBy(array(
            'year' => $year
        ));

        if($cash == null){
            $cash = new CashRegister();
            $cash->setYear($year);
            $cash->setAvialable($total);
            $cash->setEnter($total);
            $cash->setSpent(0);

            $record = null;
        }
        else{
            $record = $this->em->getRepository('SchoolAppBundle:SpentRecord')->findBy(array(
                'cashregister' => $cash
            ));
            if($record == null){
                $cash->setAvialable($total);
                $cash->setEnter($total);
                $cash->setSpent(0);
            }
            else{
                $exit = 0;
                foreach ($record as $rec){
                    $exit += $rec->getAmout();
                }
                $aviable = $total-$exit;
                $cash->setSpent($exit);
                $cash->setEnter($total);
                $cash->setAvialable($aviable);
            }
        }

        $this->em->persist($cash);
        $this->em->flush();

        $avialable = strrev($cash->getAvialable());
        $avialable = implode(' ', str_split($avialable, 3));
        $avialable = strrev($avialable);

        $enter = strrev($cash->getEnter());
        $enter = implode(' ', str_split($enter, 3));
        $enter = strrev($enter);

        $exit = strrev($cash->getSpent());
        $exit = implode(' ', str_split($exit, 3));
        $exit = strrev($exit);


        return array("cash" => $cash, "record"=>$record, "avialable"=>$avialable, "enter" => $enter, "exit" => $exit);
    }

}