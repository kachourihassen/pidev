<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * InscriptionRepas
 * @ORM\Entity()
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
    private $facture;

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="RHBundle\Entity\Enfant", inversedBy="inscriptionsRepas")
     * @JoinColumn(name="enfant", referencedColumnName="id")
     */
    private $enfant;

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="RestaurantBundle\Entity\Repas", inversedBy="inscriptions")
     * @JoinColumn(name="repas", referencedColumnName="id")
     */
    private $repas;
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

