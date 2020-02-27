<?php

namespace BibliothequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BD
 *
 * @ORM\Table(name="b_d")
 * @ORM\Entity(repositoryClass="BibliothequeBundle\Repository\BDRepository")
 */
class BD extends Document
{
    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;


    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $file;


    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Document
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }


    public function __toString(){

        return "BD" ;
    }
}