<?php

namespace ImieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="ImieBundle\Repository\PersonRepository")
 */
class person
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50)
     */
    private $country;

    /**
     * One Person has many vehicules
     * @ORM\OneToMany(targetEntity="vehicule", mappedBy="person")
     *
     */
    private $vehicules;


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
     * Set name
     *
     * @param string $name
     *
     * @return Person
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Person
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Person
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getVehicules()
    {
        return $this->vehicules;
    }

    /**
     * @param mixed $vehicules
     */
    public function setVehicules($vehicules)
    {
        $this->vehicules = $vehicules;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vehicules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add vehicule
     *
     * @param \ImieBundle\Entity\vehicule $vehicule
     *
     * @return person
     */
    public function addVehicule(\ImieBundle\Entity\vehicule $vehicule)
    {
        $this->vehicules[] = $vehicule;

        return $this;
    }

    /**
     * Remove vehicule
     *
     * @param \ImieBundle\Entity\vehicule $vehicule
     */
    public function removeVehicule(\ImieBundle\Entity\vehicule $vehicule)
    {
        $this->vehicules->removeElement($vehicule);
    }
}
