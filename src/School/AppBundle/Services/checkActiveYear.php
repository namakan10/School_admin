<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 14/09/2018
 * Time: 11:38
 */

namespace School\AppBundle\Services;

use Doctrine\ORM\EntityManager;

class checkActiveYear
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em =$em;
    }

    public function yearActive(){
        $year = $this->em->getRepository('SchoolAppBundle:Year')->findOneBy(array(
            'status' => true,
        ));

        if($year != null){
            return array("year" => $year, "definied"=>true);
        }
        else{

            return array("year" => $year, "definied"=>false);
        }
    }

}