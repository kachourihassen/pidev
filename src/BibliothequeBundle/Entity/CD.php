<?php

namespace BibliothequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CD
 *
 * @ORM\Table(name="c_d")
 * @ORM\Entity(repositoryClass="BibliothequeBundle\Repository\CDRepository")
 */
class CD extends Document
{
    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $maisonDeProd;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $file;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }
    /**
     * Set maisonDeProd
     *
     * @param string $maisonDeProd
     *
     * @return CD
     */
    public function setMaisonDeProd($maisonDeProd)
    {
        $this->maisonDeProd = $maisonDeProd;

        return $this;
    }
    /**
     * Get maisonDeProd
     *
     * @return string
     */
    public function getMaisonDeProd()
    {
        return $this->maisonDeProd;
    }

    public function __toString(){

        return "CD" ;
    }
}
