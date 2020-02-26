<?php

namespace EvaluationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Note
 * @ORM\Entity()
 * @ORM\Table(name="note")
 * @ORM\Entity()
 */
class Note
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
     * @var float
     *
     * @ORM\Column(name="valeur", type="float")
     */
    private $valeur;

    /**
     * @ManyToOne(targetEntity="RHBundle\Entity\Enfant")
     * @JoinColumn(name="enfant", referencedColumnName="id")
     */
    private $enfant;
    /**
     * @ManyToOne(targetEntity="EvaluationBundle\Entity\Matiere")
     * @JoinColumn(name="matiere", referencedColumnName="id")
     */
    private $matriere;


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
     * Set valeur
     *
     * @param float $valeur
     *
     * @return Note
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return float
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set enfant
     *
     * @param \RHBundle\Entity\Enfant $enfant
     *
     * @return Note
     */
    public function setEnfant(\RHBundle\Entity\Enfant $enfant = null)
    {
        $this->enfant = $enfant;

        return $this;
    }

    /**
     * Get enfant
     *
     * @return \RHBundle\Entity\Enfant
     */
    public function getEnfant()
    {
        return $this->enfant;
    }

    /**
     * Set matriere
     *
     * @param \EvaluationBundle\Entity\Matiere $matriere
     *
     * @return Note
     */
    public function setMatriere(\EvaluationBundle\Entity\Matiere $matriere = null)
    {
        $this->matriere = $matriere;

        return $this;
    }

    /**
     * Get matriere
     *
     * @return \EvaluationBundle\Entity\Matiere
     */
    public function getMatriere()
    {
        return $this->matriere;
    }
}
