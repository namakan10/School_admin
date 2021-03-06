<?php

namespace School\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpentRecord
 *
 * @ORM\Table(name="spent_record")
 * @ORM\Entity(repositoryClass="School\AppBundle\Repository\SpentRecordRepository")
 */
class SpentRecord
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="School\AppBundle\Entity\CashRegister", inversedBy="record")
     */
    private $cashregister;

    /**
     * @var string
     *
     * @ORM\Column(name="motive", type="text")
     */
    private $motive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="amout", type="integer")
     */
    private $amout;

    public function __construct()
    {
        $this->date = new \DateTime();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set motive
     *
     * @param string $motive
     *
     * @return SpentRecord
     */
    public function setMotive($motive)
    {
        $this->motive = $motive;

        return $this;
    }

    /**
     * Get motive
     *
     * @return string
     */
    public function getMotive()
    {
        return $this->motive;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return SpentRecord
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amout
     *
     * @param integer $amout
     *
     * @return SpentRecord
     */
    public function setAmout($amout)
    {
        $this->amout = $amout;

        return $this;
    }

    /**
     * Get amout
     *
     * @return int
     */
    public function getAmout()
    {
        return $this->amout;
    }

    /**
     * Set cashregister
     *
     * @param \School\AppBundle\Entity\CashRegister $cashregister
     *
     * @return SpentRecord
     */
    public function setCashregister(\School\AppBundle\Entity\CashRegister $cashregister = null)
    {
        $this->cashregister = $cashregister;

        return $this;
    }

    /**
     * Get cashregister
     *
     * @return \School\AppBundle\Entity\CashRegister
     */
    public function getCashregister()
    {
        return $this->cashregister;
    }
}
