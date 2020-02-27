<?php

namespace RHBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Classe
 * @ORM\Entity(repositoryClass="RHBundle\Repository\ClasseRepository")
 * @ORM\Table(name="classe")
 *
 */
class Classe
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="age_min", type="integer")
     * @Assert\GreaterThan(
     *     value = 0
     *     )
     *  @Assert\Type("integer")
     * @Assert\Expression("value < this.getAgeMax()",
     * message="age max doit etre inferieur a age min")
     */

    private $ageMin;

    /**
     * @var int
     *
     * @ORM\Column(name="age_max", type="integer")
     * @Assert\GreaterThan(value = 0)
     * @Assert\Type("integer")
     * @Assert\Expression("value > this.getAgeMin()",
     *     message="age max doit etre superieur a age min")
     */
    private $ageMax;

    /**
     * @OneToOne(targetEntity="RHBundle\Entity\Enseignant", inversedBy="classe")
     */
    private $enseignant;

    /**
     * @return mixed
     */
    public function getEnseignant()
    {
        return $this->enseignant;
    }

    /**
     * @param mixed $enseignant
     */
    public function setEnseignant($enseignant)
    {
        $this->enseignant = $enseignant;
    }




    /**
     * @var int
     *
     * @ORM\Column(name="nb_enfants_max", type="integer")
     * @Assert\GreaterThan(
     *     value = 3
     *     )
     */
    private $nbEnfantsMax;

    /**
     * @var int
     *
     * @ORM\Column(name="nbEnfants", type="integer" , nullable=true ,options={"default" : 0})
     */
    private $nbEnfants;

    /**
     * @return int
     */
    public function getNbEnfants()
    {
        return $this->nbEnfants;
    }

    /**
     * @param int $nbEnfants
     */
    public function setNbEnfants($nbEnfants)
    {
        $this->nbEnfants = $nbEnfants;
    }

    /**
     *
     * @OneToMany(targetEntity="RHBundle\Entity\Enfant", mappedBy="classe")
     */
    private $enfants;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Classe
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
     * Set ageMin
     *
     * @param integer $ageMin
     *
     * @return Classe
     */
    public function setAgeMin($ageMin)
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    /**
     * Get ageMin
     *
     * @return int
     */
    public function getAgeMin()
    {
        return $this->ageMin;
    }

    /**
     * Set ageMax
     *
     * @param integer $ageMax
     *
     * @return Classe
     */
    public function setAgeMax($ageMax)
    {
        $this->ageMax = $ageMax;

        return $this;
    }

    /**
     * Get ageMax
     *
     * @return int
     */
    public function getAgeMax()
    {
        return $this->ageMax;
    }

    /**
     * Set nbEnfantsMax
     *
     * @param integer $nbEnfantsMax
     *
     * @return Classe
     */
    public function setNbEnfantsMax($nbEnfantsMax)
    {
        $this->nbEnfantsMax = $nbEnfantsMax;

        return $this;
    }

    /**
     * Get nbEnfantsMax
     *
     * @return int
     */
    public function getNbEnfantsMax()
    {
        return $this->nbEnfantsMax;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enfants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add enfant
     *
     * @param \RHBundle\Entity\Enfant $enfant
     *
     * @return Classe
     */
    public function addEnfant(\RHBundle\Entity\Enfant $enfant)
    {
        $this->enfants[] = $enfant;

        return $this;
    }

    /**
     * Remove enfant
     *
     * @param \RHBundle\Entity\Enfant $enfant
     */
    public function removeEnfant(\RHBundle\Entity\Enfant $enfant)
    {
        $this->enfants->removeElement($enfant);
    }

    /**
     * Get enfants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnfants()
    {
        return $this->enfants;
    }

    public function __toString(){

        return $this->nom;

    }
}
