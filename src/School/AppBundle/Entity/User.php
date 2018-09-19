<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 02/09/2018
 * Time: 11:19
 */

namespace School\AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mode", type="string", length=255)
     */
    protected $mode = "USER";


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * Set mode
     *
     * @param string $mode
     *
     * @return User
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }
}
