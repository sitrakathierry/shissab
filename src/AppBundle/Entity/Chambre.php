<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chambre
 *
 * @ORM\Table(name="chambre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChambreRepository")
 */
class Chambre
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
     * @var int
     *
     * @ORM\Column(name="nb_lit_simple", type="integer", nullable=true)
     */
    private $nbLitSimple;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_lit_double", type="integer", nullable=true)
     */
    private $nbLitDouble;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_pers", type="integer", nullable=true)
     */
    private $nbPers;

    /**
     * @var string
     *
     * @ORM\Column(name="tarif_pers", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $tarifPers;

    /**
     * @var string
     *
     * @ORM\Column(name="tarif_pers_petit_dejeuner", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $tarifPersPetitDejeuner;

    /**
     * @var int
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="disponibilite", type="integer", nullable=true)
     */
    private $disponibilite = 1;

    /**
     * @var \AppBundle\Entity\CategorieChambre
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CategorieChambre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie_chambre", referencedColumnName="id")
     * })
     */
    private $categorieChambre;

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
     * @var int
     *
     * @ORM\Column(name="periode_annulation", type="integer", nullable=true)
     */
    private $periodeAnnulation = 12;

    /**
     * @var string
     *
     * @ORM\Column(name="pourcentage_remboursement", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $pourcentageRemboursement = '0.00';

    /**
     * @var int
     *
     * @ORM\Column(name="annulation_automatique", type="integer", nullable=true)
     */
    private $annulationAutomatique = 1;


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
     * @return Chambre
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
     * Set nbLitSimple
     *
     * @param integer $nbLitSimple
     *
     * @return Chambre
     */
    public function setNbLitSimple($nbLitSimple)
    {
        $this->nbLitSimple = $nbLitSimple;

        return $this;
    }

    /**
     * Get nbLitSimple
     *
     * @return int
     */
    public function getNbLitSimple()
    {
        return $this->nbLitSimple;
    }

    /**
     * Set nbLitDouble
     *
     * @param integer $nbLitDouble
     *
     * @return Chambre
     */
    public function setNbLitDouble($nbLitDouble)
    {
        $this->nbLitDouble = $nbLitDouble;

        return $this;
    }

    /**
     * Get nbLitDouble
     *
     * @return int
     */
    public function getNbLitDouble()
    {
        return $this->nbLitDouble;
    }

    /**
     * Set nbPers
     *
     * @param integer $nbPers
     *
     * @return Chambre
     */
    public function setNbPers($nbPers)
    {
        $this->nbPers = $nbPers;

        return $this;
    }

    /**
     * Get nbPers
     *
     * @return int
     */
    public function getNbPers()
    {
        return $this->nbPers;
    }

    /**
     * Set tarifPers
     *
     * @param string $tarifPers
     *
     * @return Chambre
     */
    public function setTarifPers($tarifPers)
    {
        $this->tarifPers = $tarifPers;

        return $this;
    }

    /**
     * Get tarifPers
     *
     * @return string
     */
    public function getTarifPers()
    {
        return $this->tarifPers;
    }

    /**
     * Set tarifPersPetitDejeuner
     *
     * @param string $tarifPersPetitDejeuner
     *
     * @return Chambre
     */
    public function setTarifPersPetitDejeuner($tarifPersPetitDejeuner)
    {
        $this->tarifPersPetitDejeuner = $tarifPersPetitDejeuner;

        return $this;
    }

    /**
     * Get tarifPersPetitDejeuner
     *
     * @return string
     */
    public function getTarifPersPetitDejeuner()
    {
        return $this->tarifPersPetitDejeuner;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     *
     * @return Chambre
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return int
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set disponibilite
     *
     * @param integer $disponibilite
     *
     * @return Chambre
     */
    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * Get disponibilite
     *
     * @return int
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * Set categorieChambre
     *
     * @param \AppBundle\Entity\CategorieChambre $categorieChambre
     *
     * @return Chambre
     */
    public function setCategorieChambre(\AppBundle\Entity\CategorieChambre $categorieChambre = null)
    {
        $this->categorieChambre = $categorieChambre;

        return $this;
    }

    /**
     * Get categorieChambre
     *
     * @return \AppBundle\Entity\CategorieChambre
     */
    public function getCategorieChambre()
    {
        return $this->categorieChambre;
    }

    /**
     * Set agence
     *
     * @param \AppBundle\Entity\Agence $agence
     *
     * @return Chambre
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
     * Set periodeAnnulation
     *
     * @param integer $periodeAnnulation
     *
     * @return Chambre
     */
    public function setPeriodeAnnulation($periodeAnnulation)
    {
        $this->periodeAnnulation = $periodeAnnulation;

        return $this;
    }

    /**
     * Get periodeAnnulation
     *
     * @return integer
     */
    public function getPeriodeAnnulation()
    {
        return $this->periodeAnnulation;
    }

    /**
     * Set pourcentageRemboursement
     *
     * @param string $pourcentageRemboursement
     *
     * @return Chambre
     */
    public function setPourcentageRemboursement($pourcentageRemboursement)
    {
        $this->pourcentageRemboursement = $pourcentageRemboursement ? $pourcentageRemboursement : '0.00';

        return $this;
    }

    /**
     * Get pourcentageRemboursement
     *
     * @return string
     */
    public function getPourcentageRemboursement()
    {
        return $this->pourcentageRemboursement;
    }

    /**
     * Set annulationAutomatique
     *
     * @param integer $annulationAutomatique
     *
     * @return Chambre
     */
    public function setAnnulationAutomatique($annulationAutomatique)
    {
        $this->annulationAutomatique = $annulationAutomatique;

        return $this;
    }

    /**
     * Get annulationAutomatique
     *
     * @return integer
     */
    public function getAnnulationAutomatique()
    {
        return $this->annulationAutomatique;
    }
}
