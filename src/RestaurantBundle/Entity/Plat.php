<?php

namespace RestaurantBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Plat
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\AARepository")
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
     * @return Plat
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
     * Set prix
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
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set description
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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->repas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add repa
     *
     * @param Repas $repa
     *
     * @return Plat
     */
    public function addRepa(Repas $repa)
    {
        $this->repas[] = $repa;

        return $this;
    }

    /**
     * Remove repa
     *
     * @param Repas $repa
     */
    public function removeRepa(Repas $repa)
    {
        $this->repas->removeElement($repa);
    }

    /**
     * Get repas
     *
     * @return Collection
     */
    public function getRepas()
    {
        return $this->repas;
    }
    public function __toString(){

        return $this->nom;

    }
}
