<?php

namespace EvaluationBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use RHBundle\Entity\Enfant;


/**
 * Matiere
 * @ORM\Entity()
 * @ORM\Table(name="matiere")
 * @ORM\Entity(repositoryClass="EvaluationBundle\Repository\MatiereRepository")
 */
class Matiere
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
     * @var float
     *
     * @ORM\Column(name="duree", type="float")
     */
    private $duree;

    /**
     * @var float
     *
     * @ORM\Column(name="coef", type="float")
     */
    private $coef;



    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="EvaluationBundle\Entity\Note", mappedBy="matriere")
     */
    private $notes;

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
     * Constructor
     */
    public function __construct()
    {
        $this->notes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Matiere
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
     * Set duree
     *
     * @param float $duree
     *
     * @return Matiere
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return float
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set coef
     *
     * @param float $coef
     *
     * @return Matiere
     */
    public function setCoef($coef)
    {
        $this->coef = $coef;

        return $this;
    }

    /**
     * Get coef
     *
     * @return float
     */
    public function getCoef()
    {
        return $this->coef;
    }

    /**
     * Add note
     *
     * @param \EvaluationBundle\Entity\Note $note
     *
     * @return Matiere
     */
    public function addNote(\EvaluationBundle\Entity\Note $note)
    {
        $this->notes[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param \EvaluationBundle\Entity\Note $note
     */
    public function removeNote(\EvaluationBundle\Entity\Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
