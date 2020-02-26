<?php

namespace BibliothequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
