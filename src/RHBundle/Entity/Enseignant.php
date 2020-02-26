<?php

namespace RHBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use ReclamationBundle\Entity\Reclamation;

/**
 * Enseignant
 * @ORM\Entity()
 *
 */
class Enseignant extends User
{
    public function __construct()
    {
        parent::__construct();
        parent::setRoles(['ROLE_ENSEIGNANT']);
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @var float
     *
     * @ORM\Column(name="salaire", type="float")
     */
    private $salaire;
    /**
     * One Cart has One Customer.
     * @OneToOne(targetEntity="RHBundle\Entity\Classe", inversedBy="enseignant")
     * @JoinColumn(name="classe_id", referencedColumnName="id")
     */
    private $classe;

    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="RHBundle\Entity\Conge", mappedBy="enseignant")
     */
    private $congee;


    /**
     * Set salaire
     *
     * @param float $salaire
     *
     * @return Enseignant
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;

        return $this;
    }

    /**
     * Get salaire
     *
     * @return float
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * Set classe
     *
     * @param \RHBundle\Entity\Classe $classe
     *
     * @return Enseignant
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
     * Add congee
     *
     * @param \RHBundle\Entity\Conge $congee
     *
     * @return Enseignant
     */
    public function addCongee(\RHBundle\Entity\Conge $congee)
    {
        $this->congee[] = $congee;

        return $this;
    }

    /**
     * Remove congee
     *
     * @param \RHBundle\Entity\Conge $congee
     */
    public function removeCongee(\RHBundle\Entity\Conge $congee)
    {
        $this->congee->removeElement($congee);
    }

    /**
     * Get congee
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCongee()
    {
        return $this->congee;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return \DateTime
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    /**
     * @param \DateTime $dateDeNaissance
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Add reclamation
     *
     * @param Reclamation $reclamation
     *
     * @return Enseignant
     */
    public function addReclamation(Reclamation $reclamation)
    {
        $this->reclamations[] = $reclamation;

        return $this;
    }

    /**
     * Remove reclamation
     *
     * @param Reclamation $reclamation
     */
    public function removeReclamation(Reclamation $reclamation)
    {
        $this->reclamations->removeElement($reclamation);
    }

    /**
     * Get reclamations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReclamations()
    {
        return $this->reclamations;
    }
}
