<?php

namespace BibliothequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
