<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * InscriptionRepas
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\AARepository")
 * @ORM\Table(name="inscription_repas")
 *
 */
class InscriptionRepas
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
    public $facture;

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="RHBundle\Entity\Enfant", inversedBy="inscriptionsRepas")
     * @JoinColumn(name="enfant", referencedColumnName="id")
     */
    public $enfant;

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="RestaurantBundle\Entity\Repas", inversedBy="inscriptions")
     * @JoinColumn(name="repas", referencedColumnName="id")
     */
    public $repas;
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
     * Set facture.
     *
     * @param \PaiementBundle\Entity\Facture|null $facture
     *
     * @return InscriptionRepas
     */
    public function setFacture(\PaiementBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture.
     *
     * @return \PaiementBundle\Entity\Facture|null
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set enfant.
     *
     * @param \RHBundle\Entity\Enfant|null $enfant
     *
     * @return InscriptionRepas
     */
    public function setEnfant(\RHBundle\Entity\Enfant $enfant = null)
    {
        $this->enfant = $enfant;

        return $this;
    }

    /**
     * Get enfant.
     *
     * @return \RHBundle\Entity\Enfant|null
     */
    public function getEnfant()
    {
        return $this->enfant;
    }

    /**
     * Set repas.
     *
     * @param \RestaurantBundle\Entity\Repas|null $repas
     *
     * @return InscriptionRepas
     */
    public function setRepas(\RestaurantBundle\Entity\Repas $repas = null)
    {
        $this->repas = $repas;

        return $this;
    }

    /**
     * Get repas.
     *
     * @return \RestaurantBundle\Entity\Repas|null
     */
    public function getRepas()
    {
        return $this->repas;
    }
}
