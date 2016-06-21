<?php
// src/AppBundle/Entity/User.php

namespace FrontBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\Column(name="nom", type="string")
     */
    protected $nom;


    /**
     * @ORM\Column(name="prenom", type="string")
     */
    protected $prenom;

    /**
     * @ORM\OneToMany(targetEntity="Commande", mappedBy="user",  cascade={"persist", "remove"})
     */
    protected $commandes;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->username = $this->email;
    }


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setEmail($email){
        parent::setEmail($email);
        $this->setUsername($email);
    }

    /**
     * Add commande
     *
     * @param \FrontBundle\Entity\Commande $commande
     *
     * @return User
     */
    public function addCommande(\FrontBundle\Entity\Commande $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \FrontBundle\Entity\Commande $commande
     */
    public function removeCommande(\FrontBundle\Entity\Commande $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }
}
