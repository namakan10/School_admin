<?php

namespace School\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Year
 *
 * @ORM\Table(name="year")
 * @ORM\Entity(repositoryClass="School\AppBundle\Repository\YearRepository")
 */
class Year
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
     * @ORM\OneToOne(targetEntity="School\AppBundle\Entity\CashRegister", mappedBy="year")
     */
    private $cashregister;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=255, unique=true)
     */
    private $year;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


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
     * Set year
     *
     * @param string $year
     *
     * @return Year
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Year
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set cashregister
     *
     * @param \School\AppBundle\Entity\CashRegister $cashregister
     *
     * @return Year
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
