<?php

namespace School\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classes
 *
 * @ORM\Table(name="classes")
 * @ORM\Entity(repositoryClass="School\AppBundle\Repository\ClassesRepository")
 */
class Classes
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
     * @ORM\OneToMany(targetEntity="School\AppBundle\Entity\Eleves", mappedBy="classes", cascade={"remove"})
     */
    private $eleves;


    /**
     * @var int
     *
     * @ORM\Column(name="Numero", type="integer")
     */
    private $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="Registration", type="integer")
     */
    private $registration;

    /**
     * @var int
     *
     * @ORM\Column(name="Annual", type="integer")
     */
    private $annual;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="CapMax", type="integer")
     */
    private $capMax;

    /**
     * @var int
     *
     * @ORM\Column(name="CapNow", type="integer")
     */
    private $capNow = 0 ;

    /**
     * @var string
     *
     * @ORM\Column(name="Level", type="string", length=255)
     */
    private $level;


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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Classes
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Classes
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set capMax
     *
     * @param integer $capMax
     *
     * @return Classes
     */
    public function setCapMax($capMax)
    {
        $this->capMax = $capMax;

        return $this;
    }

    /**
     * Get capMax
     *
     * @return int
     */
    public function getCapMax()
    {
        return $this->capMax;
    }

    /**
     * Set capNow
     *
     * @param integer $capNow
     *
     * @return Classes
     */
    public function setCapNow($capNow)
    {
        $this->capNow = $capNow;

        return $this;
    }

    /**
     * Get capNow
     *
     * @return int
     */
    public function getCapNow()
    {
        return $this->capNow;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return Classes
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eleves = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add elefe
     *
     * @param \School\AppBundle\Entity\Eleves $elefe
     *
     * @return Classes
     */
    public function addElefe(\School\AppBundle\Entity\Eleves $elefe)
    {
        $this->eleves[] = $elefe;

        return $this;
    }

    /**
     * Remove elefe
     *
     * @param \School\AppBundle\Entity\Eleves $elefe
     */
    public function removeElefe(\School\AppBundle\Entity\Eleves $elefe)
    {
        $this->eleves->removeElement($elefe);
    }

    /**
     * Get eleves
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEleves()
    {
        return $this->eleves;
    }


    /**
     * Set registration
     *
     * @param integer $registration
     *
     * @return Classes
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration
     *
     * @return integer
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Set annual
     *
     * @param integer $annual
     *
     * @return Classes
     */
    public function setAnnual($annual)
    {
        $this->annual = $annual;

        return $this;
    }

    /**
     * Get annual
     *
     * @return integer
     */
    public function getAnnual()
    {
        return $this->annual;
    }
}
