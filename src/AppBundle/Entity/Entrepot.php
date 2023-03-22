<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entrepot
 *
 * @ORM\Table(name="entrepot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntrepotRepository")
 */
class Entrepot
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
     * @ORM\Column(name="nom", type="text", nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text", nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;

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
     * @var string
     *
     * @ORM\Column(name="devise_symbole", type="text", nullable=true)
     */
    private $deviseSymbole;

    /**
     * @var string
     *
     * @ORM\Column(name="devise_lettre", type="text", nullable=true)
     */
    private $deviseLettre;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Entrepot
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Entrepot
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Entrepot
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set agence
     *
     * @param \AppBundle\Entity\Agence $agence
     *
     * @return Entrepot
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

    /**
     * Set deviseSymbole
     *
     * @param string $deviseSymbole
     *
     * @return Entrepot
     */
    public function setDeviseSymbole($deviseSymbole)
    {
        $this->deviseSymbole = $deviseSymbole;

        return $this;
    }

    /**
     * Get deviseSymbole
     *
     * @return string
     */
    public function getDeviseSymbole()
    {
        return $this->deviseSymbole;
    }

    /**
     * Set deviseLettre
     *
     * @param string $deviseLettre
     *
     * @return Entrepot
     */
    public function setDeviseLettre($deviseLettre)
    {
        $this->deviseLettre = $deviseLettre;

        return $this;
    }

    /**
     * Get deviseLettre
     *
     * @return string
     */
    public function getDeviseLettre()
    {
        return $this->deviseLettre;
    }
}
