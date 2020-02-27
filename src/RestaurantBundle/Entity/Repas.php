<?php

namespace RestaurantBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Repas
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\AARepository")
 * @ORM\Table(name="repas")
 *
 */
class Repas
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
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="datetime")
     */
    private $heure;

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
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="RestaurantBundle\Entity\InscriptionRepas", mappedBy="repas")
     */
    private $inscriptions;

    /**
     * Many Users have Many Groups.
     * @ManyToMany(targetEntity="RestaurantBundle\Entity\Plat", inversedBy="repas")
     * @JoinTable(name="plat_repas")
     */
    private $plats;





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
        $this->inscriptions = new ArrayCollection();
        $this->plats = new ArrayCollection();
    }

    /**
     * Add inscription
     *
     * @param InscriptionRepas $inscription
     *
     * @return Repas
     */
    public function addInscription(InscriptionRepas $inscription)
    {
        $this->inscriptions[] = $inscription;

        return $this;
    }

    /**
     * Remove inscription
     *
     * @param InscriptionRepas $inscription
     */
    public function removeInscription(InscriptionRepas $inscription)
    {
        $this->inscriptions->removeElement($inscription);
    }

    /**
     * Get inscriptions
     *
     * @return Collection
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Repas
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
     * Set heure
     *
     * @param \DateTime $heure
     *
     * @return Repas
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return \DateTime
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Repas
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
     * @return Repas
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
     * Add plat
     *
     * @param Plat $plat
     *
     * @return Repas
     */
    public function addPlat(Plat $plat)
    {
        $this->plats[] = $plat;

        return $this;
    }

    /**
     * Remove plat
     *
     * @param Plat $plat
     */
    public function removePlat(Plat $plat)
    {
        $this->plats->removeElement($plat);
    }

    /**
     * Get plats
     *
     * @return Collection
     */
    public function getPlats()
    {
        return $this->plats;
    }
    public function __toString(){

        return $this->nom;

    }


}
