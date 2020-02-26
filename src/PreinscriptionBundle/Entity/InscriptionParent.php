<?php

namespace PreinscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * InscriptionParent
 *
 * @ORM\Table(name="inscription_parent")
 * @ORM\Entity(repositoryClass="PreinscriptionBundle\Repository\InscriptionParentRepository")
 */
class InscriptionParent
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @ManyToOne(targetEntity="PreinscriptionBundle\Entity\ParentPreInscrit")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return InscriptionParent
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set parent
     *
     * @param \PreinscriptionBundle\Entity\ParentPreInscrit $parent
     *
     * @return InscriptionParent
     */
    public function setParent(\PreinscriptionBundle\Entity\ParentPreInscrit $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \PreinscriptionBundle\Entity\ParentPreInscrit
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function __toString(){

        return (string) $this->getId();

    }
}
