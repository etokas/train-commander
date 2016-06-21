<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @ORM\OneToOne(targetEntity="Voyage", cascade={"persist", "remove"})
     */
    private $voyage;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="commandes",  cascade={"persist", "remove"})
     */
    private $user;


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
     * Set voyage
     *
     * @param \FrontBundle\Entity\Voyage $voyage
     *
     * @return Commande
     */
    public function setVoyage(\FrontBundle\Entity\Voyage $voyage = null)
    {
        $this->voyage = $voyage;

        return $this;
    }

    /**
     * Get voyage
     *
     * @return \FrontBundle\Entity\Voyage
     */
    public function getVoyage()
    {
        return $this->voyage;
    }

    /**
     * Set user
     *
     * @param \FrontBundle\Entity\User $user
     *
     * @return Commande
     */
    public function setUser(\FrontBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FrontBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
