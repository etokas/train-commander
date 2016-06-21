<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="voyage")
 * @ORM\Entity
 */
class Voyage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $TrajetId;

    /**
     * @ORM\Column(name="type_train", type="string")
     */
    private $TypeTrain;

    /**
     * @ORM\Column(name="train_id", type="integer")
     */
    private $TrainId;

    /**
     * @ORM\Column(name="gare_depart", type="string")
     */
    private $GareDepart;

    /**
     * @ORM\Column(name="gare_arrivee", type="string")
     */
    private $GareArrivee;

    /**
     * @ORM\Column(name="first_correspondance", type="integer", nullable=true)
     */
    private $TrajetPremiereCorrespondance;

    /**
     * @ORM\Column(name="second_correspondance", type="string", nullable=true)
     */
    private $TrajetDeuxiemeCorrespondance;

    /**
     * @ORM\Column(name="prix", type="float")
     */
    private $Prix;

    /**
     * @ORM\Column(name="heure_depart", type="string")
     */
    private $HeureDepart;

    /**
     * @ORM\Column(name="heure_arrivee", type="string")
     */
    private $HeureArrivee;

    /**
     * @ORM\Column(name="ville_depart", type="string")
     */
    private $VilleDepart;

    /**
     * @ORM\Column(name="ville_arrivee", type="string")
     */
    private $VilleArrivee;

    /**
     * @ORM\Column(name="ville_depart_id", type="integer")
     */
    private $VilleDepartId;

    /**
     * @ORM\Column(name="ville_arrivee_id", type="integer")
     */
    private $VilleArriveeId;


    /**
     * Get TrajetId
     *
     * @return integer
     */
    public function getTrajetId()
    {
        return $this->TrajetId;
    }

    /**
     * Get TrajetId
     *
     * @return integer
     */
    public function setTrajetId()
    {
        return $this->TrajetId;
    }

    /**
     * Set typeTrain
     *
     * @param string $typeTrain
     *
     * @return Voyage
     */
    public function setTypeTrain($typeTrain)
    {
        $this->TypeTrain = $typeTrain;

        return $this;
    }

    /**
     * Get typeTrain
     *
     * @return string
     */
    public function getTypeTrain()
    {
        return $this->TypeTrain;
    }

    /**
     * Set trainId
     *
     * @param integer $trainId
     *
     * @return Voyage
     */
    public function setTrainId($trainId)
    {
        $this->TrainId = $trainId;

        return $this;
    }

    /**
     * Get trainId
     *
     * @return integer
     */
    public function getTrainId()
    {
        return $this->TrainId;
    }

    /**
     * Set gareDepart
     *
     * @param string $gareDepart
     *
     * @return Voyage
     */
    public function setGareDepart($gareDepart)
    {
        $this->GareDepart = $gareDepart;

        return $this;
    }

    /**
     * Get gareDepart
     *
     * @return string
     */
    public function getGareDepart()
    {
        return $this->GareDepart;
    }

    /**
     * Set gareArrivee
     *
     * @param string $gareArrivee
     *
     * @return Voyage
     */
    public function setGareArrivee($gareArrivee)
    {
        $this->GareArrivee = $gareArrivee;

        return $this;
    }

    /**
     * Get gareArrivee
     *
     * @return string
     */
    public function getGareArrivee()
    {
        return $this->GareArrivee;
    }

    /**
     * Set trajetPremiereCorrespondance
     *
     * @param integer $trajetPremiereCorrespondance
     *
     * @return Voyage
     */
    public function setTrajetPremiereCorrespondance($trajetPremiereCorrespondance)
    {
        $this->TrajetPremiereCorrespondance = $trajetPremiereCorrespondance;

        return $this;
    }

    /**
     * Get trajetPremiereCorrespondance
     *
     * @return integer
     */
    public function getTrajetPremiereCorrespondance()
    {
        return $this->TrajetPremiereCorrespondance;
    }

    /**
     * Set trajetDeuxiemeCorrespondance
     *
     * @param string $trajetDeuxiemeCorrespondance
     *
     * @return Voyage
     */
    public function setTrajetDeuxiemeCorrespondance($trajetDeuxiemeCorrespondance)
    {
        $this->TrajetDeuxiemeCorrespondance = $trajetDeuxiemeCorrespondance;

        return $this;
    }

    /**
     * Get trajetDeuxiemeCorrespondance
     *
     * @return string
     */
    public function getTrajetDeuxiemeCorrespondance()
    {
        return $this->TrajetDeuxiemeCorrespondance;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Voyage
     */
    public function setPrix($prix)
    {
        $this->Prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->Prix;
    }

    /**
     * Set heureDepart
     *
     * @param string $heureDepart
     *
     * @return Voyage
     */
    public function setHeureDepart($heureDepart)
    {
        $this->HeureDepart = $heureDepart;

        return $this;
    }

    /**
     * Get heureDepart
     *
     * @return string
     */
    public function getHeureDepart()
    {
        return $this->HeureDepart;
    }

    /**
     * Set heureArrivee
     *
     * @param string $heureArrivee
     *
     * @return Voyage
     */
    public function setHeureArrivee($heureArrivee)
    {
        $this->HeureArrivee = $heureArrivee;

        return $this;
    }

    /**
     * Get heureArrivee
     *
     * @return string
     */
    public function getHeureArrivee()
    {
        return $this->HeureArrivee;
    }

    /**
     * Set villeDepart
     *
     * @param string $villeDepart
     *
     * @return Voyage
     */
    public function setVilleDepart($villeDepart)
    {
        $this->VilleDepart = $villeDepart;

        return $this;
    }

    /**
     * Get villeDepart
     *
     * @return string
     */
    public function getVilleDepart()
    {
        return $this->VilleDepart;
    }

    /**
     * Set villeArrivee
     *
     * @param string $villeArrivee
     *
     * @return Voyage
     */
    public function setVilleArrivee($villeArrivee)
    {
        $this->VilleArrivee = $villeArrivee;

        return $this;
    }

    /**
     * Get villeArrivee
     *
     * @return string
     */
    public function getVilleArrivee()
    {
        return $this->VilleArrivee;
    }

    /**
     * Set villeDepartId
     *
     * @param integer $villeDepartId
     *
     * @return Voyage
     */
    public function setVilleDepartId($villeDepartId)
    {
        $this->VilleDepartId = $villeDepartId;

        return $this;
    }

    /**
     * Get villeDepartId
     *
     * @return integer
     */
    public function getVilleDepartId()
    {
        return $this->VilleDepartId;
    }

    /**
     * Set villeArriveeId
     *
     * @param integer $villeArriveeId
     *
     * @return Voyage
     */
    public function setVilleArriveeId($villeArriveeId)
    {
        $this->VilleArriveeId = $villeArriveeId;

        return $this;
    }

    /**
     * Get villeArriveeId
     *
     * @return integer
     */
    public function getVilleArriveeId()
    {
        return $this->VilleArriveeId;
    }
}
