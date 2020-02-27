<?php
/**
 * Created by PhpStorm.
 * User: oussema
 * Date: 2/24/2020
 * Time: 01:38
 */

namespace BibliothequeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity
 * @ORM\Table(name="Livre_emprunter")
 */
class Emprunter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="RHBundle\Entity\Enfant" , inversedBy="enfantEmprunt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enfant;

    /**
     * @ORM\ManyToOne(targetEntity="BibliothequeBundle\Entity\Document" , inversedBy="documentEmpruntes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $document;

    /**
     * @var date
     *
     * @ORM\Column(name="date_emprunt", type="date" )
     */
    private $dateEmprunt;

    /**
     * Emprunter constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEnfant()
    {
        return $this->enfant;
    }

    /**
     * @param mixed $enfant
     */
    public function setEnfant($enfant)
    {
        $this->enfant = $enfant;
    }

    /**
     * @return mixed
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param mixed $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * @return Date
     */
    public function getDateEmprunt()
    {
        return $this->dateEmprunt;
    }

    /**
     * @param Date $dateEmprunt
     */
    public function setDateEmprunt($dateEmprunt)
    {
        $this->dateEmprunt = $dateEmprunt;
    }









}