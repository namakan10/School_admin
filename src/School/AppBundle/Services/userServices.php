<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 17/09/2018
 * Time: 14:51
 */

namespace School\AppBundle\Services;


use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;

class userServices
{
    private $encoder;

    public function __construct(BasePasswordEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function encode($pass){
        $pass = $this->encoder->encodePassword();
    }

}