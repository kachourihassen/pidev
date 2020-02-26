<?php


namespace ReclamationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification Parent
 * @ORM\Entity()
 */
class NotificationParent extends Notification
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="vue_par_l_admin", type="boolean")
     */
    private $vueParLAdmin=false;

    /**
     * Set parent.
     *
     * @param \AppBundle\Entity\User|null $parent
     *
     * @return Reclamation
     */
    public function setParent(\AppBundle\Entity\User $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set vueParLAdmin.
     *
     * @param bool $vueParLAdmin
     *
     * @return NotificationParent
     */
    public function setVueParLAdmin($vueParLAdmin)
    {
        $this->vueParLAdmin = $vueParLAdmin;

        return $this;
    }

    /**
     * Get vueParLAdmin.
     *
     * @return bool
     */
    public function getVueParLAdmin()
    {
        return $this->vueParLAdmin;
    }
}
