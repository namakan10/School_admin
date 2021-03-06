<?php

namespace School\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity(repositoryClass="School\AppBundle\Repository\PaymentRepository")
 */
class Payment
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
     * @ORM\OneToOne(targetEntity="School\AppBundle\Entity\Eleves", mappedBy="pay", cascade={"persist"})
     */
    private $student;

    /**
     * @var int
     *
     * @ORM\Column(name="amout", type="integer")
     */
    private $amout;

    /**
     * @ORM\ManyToOne(targetEntity="School\AppBundle\Entity\Year")
     */
    private $year;


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
     * Set amout
     *
     * @param integer $amout
     *
     * @return Payment
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
     * Set student
     *
     * @param \School\AppBundle\Entity\Eleves $student
     *
     * @return Payment
     */
    public function setStudent(\School\AppBundle\Entity\Eleves $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \School\AppBundle\Entity\Eleves
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set year
     *
     * @param \School\AppBundle\Entity\Year $year
     *
     * @return Payment
     */
    public function setYear(\School\AppBundle\Entity\Year $year = null)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \School\AppBundle\Entity\Year
     */
    public function getYear()
    {
        return $this->year;
    }
}
