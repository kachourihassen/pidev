<?php

namespace BibliothequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;


/**
 * Document
 *  @ORM\Entity
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="categorie", type="string")
 * @DiscriminatorMap({"document" = "Document","cd" = "CD","livre" = "Livre","bd" = "BD"})
 * @ORM\Table(name="document")
 *
 */
class Document
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    protected $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=255)
     */
    protected $langue;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    protected $prix;



    /**
     * @param mixed $path
     */


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePub", type="datetime")
     */
    protected $datePub;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @var date
     * @ORM\Column(name="endDateEmprunt", type="date")
     */
    public $endDateEmprunt;

    /**
     * @return Date
     */
    public function getEndDateEmprunt()
    {
        return $this->endDateEmprunt;
    }

    /**
     * @param Date $endDateEmprunt
     */
    public function setEndDateEmprunt($endDateEmprunt)
    {
        $this->endDateEmprunt = $endDateEmprunt;
    }






    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\OneToMany(targetEntity="BibliothequeBundle\Entity\Emprunter", mappedBy="document", fetch="EXTRA_LAZY")
     */
    private $documentEmpruntes;

    /**
     * @return mixed
     */
    public function getDocumentEmpruntes()
    {
        return $this->documentEmpruntes;
    }

    /**
     * @param mixed $documentEmpruntes
     */
    public function setDocumentEmpruntes($documentEmpruntes)
    {
        $this->documentEmpruntes = $documentEmpruntes;
    }



    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }





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
     * Set titre
     *
     * @param string $titre
     *
     * @return Document
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Document
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
     * Set langue
     *
     * @param string $langue
     *
     * @return Document
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return string
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Document
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
     * Set datePub
     *
     * @param \DateTime $datePub
     *
     * @return Document
     */
    public function setDatePub($datePub)
    {
        $this->datePub = $datePub;

        return $this;
    }

    /**
     * Get datePub
     *
     * @return \DateTime
     */
    public function getDatePub()
    {
        return $this->datePub;
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inscriptions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add inscription
     *
     * @param Inscription $inscription
     *
     * @return Document
     */
    public function addInscription(Inscription $inscription)
    {
        $this->inscriptions[] = $inscription;

        return $this;
    }

    /**
     * Remove inscription
     *
     * @param Inscription $inscription
     */
    public function removeInscription(Inscription $inscription)
    {
        $this->inscriptions->removeElement($inscription);
        $this->rates = new \Doctrine\Common\Collections\ArrayCollection();
    }



    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the _DIR_ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/films';
    }
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */


    /**
     * Get file.
     *
     * @return UploadedFile
     */

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }






}
