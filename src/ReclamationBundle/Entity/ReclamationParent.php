<?php


namespace ReclamationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Reclamation Parent
 * @ORM\Entity()
 */

class ReclamationParent  extends Reclamation
{
    /**
     * @ORM\ManyToOne(targetEntity="ReclamationBundle\Entity\Status", inversedBy="reclamations")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="RHBundle\Entity\UserParent")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="text")
     */
    private $reponse;
    /**
     * Set status.
     *
     * @param \ReclamationBundle\Entity\Status|null $status
     *
     * @return Reclamation
     */
    public function setStatus(\ReclamationBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return \ReclamationBundle\Entity\Status|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set parent.
     *
     * @param \RHBundle\Entity\UserParent|null $parent
     *
     * @return Reclamation
     */
    public function setParent(\RHBundle\Entity\UserParent $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \RHBundle\Entity\UserParent|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set reponse
     *
     * @param string $reponse
     *
     * @return Reclamation
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }

}