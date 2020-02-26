<?php

namespace RHBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Enfant
 * @ORM\Entity
 * @ORM\Table(name="enfant")
 *  @ORM\Entity()
 */
class Enfant
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
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
 * @var \DateTime
 *
 * @ORM\Column(name="date_naissance" , type="datetime")
 */
    private $dateNaissance;


    /**
     * @ManyToOne(targetEntity="RHBundle\Entity\Classe")
     * @JoinColumn(name="classe", referencedColumnName="id")
     */
    private $classe;

    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="EvenementBundle\Entity\Inscription", mappedBy="enfant")
     */
    private $inscriptionsEvent;

    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="ActiviteBundle\Entity\InscriptionActivite", mappedBy="enfant")
     */
    private $inscriptionsActivite;
    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="RestaurantBundle\Entity\InscriptionRepas", mappedBy="enfant")
     */
    private $inscriptionsRepas;
    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="EvaluationBundle\Entity\Note", mappedBy="enfant")
     */
    private $notes;

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="RHBundle\Entity\UserParent", inversedBy="enfants")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inscriptionsEvent = new ArrayCollection();
        $this->inscriptionsActivite = new ArrayCollection();
        $this->inscriptionsRepas = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Enfant
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Enfant
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Enfant
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Enfant
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set classe
     *
     * @param \RHBundle\Entity\Classe $classe
     *
     * @return Enfant
     */
    public function setClasse(\RHBundle\Entity\Classe $classe = null)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \RHBundle\Entity\Classe
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Add inscriptionsEvent
     *
     * @param \EvenementBundle\Entity\Inscription $inscriptionsEvent
     *
     * @return Enfant
     */
    public function addInscriptionsEvent(\EvenementBundle\Entity\Inscription $inscriptionsEvent)
    {
        $this->inscriptionsEvent[] = $inscriptionsEvent;

        return $this;
    }

    /**
     * Remove inscriptionsEvent
     *
     * @param \EvenementBundle\Entity\Inscription $inscriptionsEvent
     */
    public function removeInscriptionsEvent(\EvenementBundle\Entity\Inscription $inscriptionsEvent)
    {
        $this->inscriptionsEvent->removeElement($inscriptionsEvent);
    }

    /**
     * Get inscriptionsEvent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInscriptionsEvent()
    {
        return $this->inscriptionsEvent;
    }

    /**
     * Add inscriptionsActivite
     *
     * @param \ActiviteBundle\Entity\InscriptionActivite $inscriptionsActivite
     *
     * @return Enfant
     */
    public function addInscriptionsActivite(\ActiviteBundle\Entity\InscriptionActivite $inscriptionsActivite)
    {
        $this->inscriptionsActivite[] = $inscriptionsActivite;

        return $this;
    }

    /**
     * Remove inscriptionsActivite
     *
     * @param \ActiviteBundle\Entity\InscriptionActivite $inscriptionsActivite
     */
    public function removeInscriptionsActivite(\ActiviteBundle\Entity\InscriptionActivite $inscriptionsActivite)
    {
        $this->inscriptionsActivite->removeElement($inscriptionsActivite);
    }

    /**
     * Get inscriptionsActivite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInscriptionsActivite()
    {
        return $this->inscriptionsActivite;
    }

    /**
     * Add inscriptionsRepa
     *
     * @param \RestaurantBundle\Entity\InscriptionRepas $inscriptionsRepa
     *
     * @return Enfant
     */
    public function addInscriptionsRepa(\RestaurantBundle\Entity\InscriptionRepas $inscriptionsRepa)
    {
        $this->inscriptionsRepas[] = $inscriptionsRepa;

        return $this;
    }

    /**
     * Remove inscriptionsRepa
     *
     * @param \RestaurantBundle\Entity\InscriptionRepas $inscriptionsRepa
     */
    public function removeInscriptionsRepa(\RestaurantBundle\Entity\InscriptionRepas $inscriptionsRepa)
    {
        $this->inscriptionsRepas->removeElement($inscriptionsRepa);
    }

    /**
     * Get inscriptionsRepas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInscriptionsRepas()
    {
        return $this->inscriptionsRepas;
    }

    /**
     * Add note
     *
     * @param \EvaluationBundle\Entity\Note $note
     *
     * @return Enfant
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

    /**
     * Set parent
     *
     * @param \RHBundle\Entity\UserParent $parent
     *
     * @return Enfant
     */
    public function setParent(\RHBundle\Entity\UserParent $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \RHBundle\Entity\UserParent
     */
    public function getParent()
    {
        return $this->parent;
    }
    public function __toString(){

        return $this->nom;

    }
}
