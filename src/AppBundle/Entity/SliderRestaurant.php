<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SliderRestaurant
 *
 * @ORM\Table(name="slider_restaurant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SliderRestaurantRepository")
 */
class SliderRestaurant
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
     * @var string
     *
     * @ORM\Column(name="titre", type="text", nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="sous_titre", type="text", nullable=true)
     */
    private $sousTitre;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="text", nullable=true)
     */
    private $img;

    /**
     * @var \AppBundle\Entity\Agence
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Agence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agence", referencedColumnName="id")
     * })
     */
    private $agence;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return SliderRestaurant
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set sousTitre
     *
     * @param string $sousTitre
     *
     * @return SliderRestaurant
     */
    public function setSousTitre($sousTitre)
    {
        $this->sousTitre = $sousTitre;

        return $this;
    }

    /**
     * Get sousTitre
     *
     * @return string
     */
    public function getSousTitre()
    {
        return $this->sousTitre;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return SliderRestaurant
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set agence
     *
     * @param \AppBundle\Entity\Agence $agence
     *
     * @return SliderRestaurant
     */
    public function setAgence(\AppBundle\Entity\Agence $agence = null)
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * Get agence
     *
     * @return \AppBundle\Entity\Agence
     */
    public function getAgence()
    {
        return $this->agence;
    }
}
