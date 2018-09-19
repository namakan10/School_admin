<?php

namespace School\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payrecord
 *
 * @ORM\Table(name="payrecord")
 * @ORM\Entity(repositoryClass="School\AppBundle\Repository\PayrecordRepository")
 */
class Payrecord
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
     * @ORM\ManyToOne(targetEntity="School\AppBundle\Entity\Eleves", inversedBy="record")
     */
    private $student;

    /**
     * @var int
     *
     * @ORM\Column(name="amout", type="integer")
     */
    private $amout;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="string", length=255)
     */
    private $motif;

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
     * @return Payrecord
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Payrecord
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
     * Set motif
     *
     * @param string $motif
     *
     * @return Payrecord
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set student
     *
     * @param \School\AppBundle\Entity\Eleves $student
     *
     * @return Payrecord
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
     * @return Payrecord
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
