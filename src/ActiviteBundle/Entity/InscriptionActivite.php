<?php

namespace ActiviteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * InscriptionActivite
 *
 * @ORM\Table(name="inscription_activite")
 * @ORM\Entity(repositoryClass="ActiviteBundle\Repository\InscriptionActiviteRepository")
 */
class InscriptionActivite
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
     *
     * @OneToOne(targetEntity="PaiementBundle\Entity\Facture")
     * @JoinColumn(name="facture", referencedColumnName="id")
     */
    private $facture;

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="RHBundle\Entity\Enfant", inversedBy="inscriptionsActivite")
     * @JoinColumn(name="enfant", referencedColumnName="id")
     */
    private $enfant;

    /**
     * @return mixed
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * @param mixed $facture
     */
    public function setFacture($facture)
    {
        $this->facture = $facture;
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
    public function getActivite()
    {
        return $this->activite;
    }

    /**
     * @param mixed $activite
     */
    public function setActivite($activite)
    {
        $this->activite = $activite;
    }

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="ActiviteBundle\Entity\Activite", inversedBy="inscriptions")
     * @JoinColumn(name="activite", referencedColumnName="id")
     */
    private $activite;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


}
