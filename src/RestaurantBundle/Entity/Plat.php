<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Plat
 * @ORM\Entity()
 * @ORM\Table(name="plat")
 *
 */
class Plat
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
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * Many Groups have Many Users.
     * @ManyToMany(targetEntity="RestaurantBundle\Entity\Repas", mappedBy="plats")
     */
    private $repas;


    public function __toString(){

        return $this->nom;

    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->repas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Plat
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prix.
     *
     * @param float $prix
     *
     * @return Plat
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix.
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Plat
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add repa.
     *
     * @param \RestaurantBundle\Entity\Repas $repa
     *
     * @return Plat
     */
    public function addRepas(\RestaurantBundle\Entity\Repas $repa)
    {
        $this->repas[] = $repa;

        return $this;
    }

    /**
     * Remove repa.
     *
     * @param \RestaurantBundle\Entity\Repas $repa
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeRepas(\RestaurantBundle\Entity\Repas $repa)
    {
        return $this->repas->removeElement($repa);
    }

    /**
     * Get repas.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRepas()
    {
        return $this->repas;
    }

    /**
     * Add repa.
     *
     * @param \RestaurantBundle\Entity\Repas $repa
     *
     * @return Plat
     */
    public function addRepa(\RestaurantBundle\Entity\Repas $repa)
    {
        $this->repas[] = $repa;

        return $this;
    }

    /**
     * Remove repa.
     *
     * @param \RestaurantBundle\Entity\Repas $repa
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeRepa(\RestaurantBundle\Entity\Repas $repa)
    {
        return $this->repas->removeElement($repa);
    }


}
