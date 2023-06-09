<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="fk_facture_client_idx", columns={"client"}), @ORM\Index(name="fk_facture_agence_idx", columns={"agence"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactureRepository")
 */
class Facture
{
    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="modele", type="integer", nullable=true)
     */
    private $modele = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date", nullable=true)
     */
    private $dateCreation = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_livr_c", type="date", nullable=true)
     */
    private $dateLivrCom = '';

    

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="text", nullable=true)
     */
    private $lieu;

    /**
     * @var integer
     *
     * @ORM\Column(name="num", type="integer", nullable=true)
     */
    private $num = '';

    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montant = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="remise_type", type="integer", nullable=true)
     */
    private $remiseType = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="remise_pourcentage", type="integer", nullable=true)
     */
    private $remisePourcentage = '';

    /**
     * @var string
     *
     * @ORM\Column(name="remise_valeur", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $remiseValeur = '';

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $total = '';

    /**
     * @var string
     *
     * @ORM\Column(name="somme", type="text", nullable=true)
     */
    private $somme = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="num_police")
     * })
     */
    private $client;

    private $formattedNum;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text", nullable=true)
     */
    private $descr = '';

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
     * @var \AppBundle\Entity\Facture
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proforma", referencedColumnName="id")
     * })
     */
    private $proforma;

    /**
     * @var \AppBundle\Entity\ModelePdf
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ModelePdf")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modele_pdf", referencedColumnName="id")
     * })
     */
    private $modelePdf;

    /**
     * @var \AppBundle\Entity\Credit
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Credit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="credit", referencedColumnName="id")
     * })
     */
    private $credit;

    /**
     * @var int
     *
     * @ORM\Column(name="is_credit", type="integer", nullable=true)
     */
    private $is_credit = 0;


    /**
     * @var \AppBundle\Entity\Devise
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Devise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="devise", referencedColumnName="id")
     * })
     */
    private $devise;

    /**
     * @var string
     *
     * @ORM\Column(name="montant_converti", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montantConverti = '0.00';

    /**
     * @var int
     *
     * @ORM\Column(name="is_delete", type="integer", nullable=true)
     */
    private $is_delete;

    public function getFormattedNum()
    {
        $statusFacture = "" ;

        if($this->is_credit == 1)
        $statusFacture = "-CREDIT" ;
         else if ($this->is_credit == 3)
        $statusFacture = "-SOUS ACOMPTE" ;

        $this->formattedNum = (($this->type == 1 || $this->type == 3 ) ? "PR-" : "DF-") . str_pad($this->num, 3, '0', STR_PAD_LEFT) . "/" . $this->dateCreation->format('y') . $statusFacture;

        return $this->formattedNum;
    }


    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Facture
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Facture
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Facture
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
     * Set dateLivrCom
     *
     * @param \DateTime $dateLivrCom
     *
     * @return Facture
     */
    public function setDateLivrCom($dateLivrCom = null)
    {
        $this->dateLivrCom = $dateLivrCom;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDateLivrCom()
    {
        return $this->dateLivrCom;
    }

    /**
     * Set num
     *
     * @param integer $num
     *
     * @return Facture
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return Facture
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set remisePourcentage
     *
     * @param integer $remisePourcentage
     *
     * @return Facture
     */
    public function setRemisePourcentage($remisePourcentage)
    {
        $this->remisePourcentage = $remisePourcentage;

        return $this;
    }

    /**
     * Get remisePourcentage
     *
     * @return integer
     */
    public function getRemisePourcentage()
    {
        return $this->remisePourcentage;
    }

    /**
     * Set remiseValeur
     *
     * @param string $remiseValeur
     *
     * @return Facture
     */
    public function setRemiseValeur($remiseValeur)
    {
        $this->remiseValeur = $remiseValeur ? $remiseValeur : '0.00';

        return $this;
    }

    /**
     * Get remiseValeur
     *
     * @return string
     */
    public function getRemiseValeur()
    {
        return $this->remiseValeur;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Facture
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set somme
     *
     * @param string $somme
     *
     * @return Facture
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;

        return $this;
    }

    /**
     * Get somme
     *
     * @return string
     */
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descr
     *
     * @param string $descr
     *
     * @return Facture
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;

        return $this;
    }

    /**
     * Get descr
     *
     * @return string
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Facture
     */
    public function setClient(\AppBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set agence
     *
     * @param \AppBundle\Entity\Agence $agence
     *
     * @return Facture
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
     * Set proforma
     *
     * @param \AppBundle\Entity\Facture $proforma
     *
     * @return Facture
     */
    public function setProforma(\AppBundle\Entity\Facture $proforma = null)
    {
        $this->proforma = $proforma;
    
        return $this;
    }

    /**
     * Get proforma
     *
     * @return \AppBundle\Entity\Facture
     */
    public function getProforma()
    {
        return $this->proforma;
    }

    /**
     * Set modele
     *
     * @param integer $modele
     *
     * @return Facture
     */
    public function setModele($modele)
    {
        $this->modele = $modele;
    
        return $this;
    }

    /**
     * Get modele
     *
     * @return integer
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set modelePdf
     *
     * @param \AppBundle\Entity\ModelePdf $modelePdf
     *
     * @return Facture
     */
    public function setModelePdf(\AppBundle\Entity\ModelePdf $modelePdf = null)
    {
        $this->modelePdf = $modelePdf;

        return $this;
    }

    /**
     * Get modelePdf
     *
     * @return \AppBundle\Entity\ModelePdf
     */
    public function getModelePdf()
    {
        return $this->modelePdf;
    }

    /**
     * Set remiseType
     *
     * @param integer $remiseType
     *
     * @return Facture
     */
    public function setRemiseType($remiseType)
    {
        $this->remiseType = $remiseType;

        return $this;
    }

    /**
     * Get remiseType
     *
     * @return integer
     */
    public function getRemiseType()
    {
        return $this->remiseType;
    }

    /**
     * Set credit
     *
     * @param \AppBundle\Entity\Credit $credit
     *
     * @return Facture
     */
    public function setCredit(\AppBundle\Entity\Credit $credit = null)
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get credit
     *
     * @return \AppBundle\Entity\Credit
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Set isCredit
     *
     * @param integer $isCredit
     *
     * @return Facture
     */
    public function setIsCredit($isCredit)
    {
        $this->is_credit = $isCredit;

        return $this;
    }

    /**
     * Get isCredit
     *
     * @return integer
     */
    public function getIsCredit()
    {
        return $this->is_credit;
    }

    /**
     * Set montantConverti
     *
     * @param string $montantConverti
     *
     * @return Facture
     */
    public function setMontantConverti($montantConverti)
    {
        $this->montantConverti = $montantConverti ? $montantConverti : '0.00';

        return $this;
    }

    /**
     * Get montantConverti
     *
     * @return string
     */
    public function getMontantConverti()
    {
        return $this->montantConverti;
    }

    /**
     * Set devise
     *
     * @param \AppBundle\Entity\Devise $devise
     *
     * @return Facture
     */
    public function setDevise(\AppBundle\Entity\Devise $devise = null)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get devise
     *
     * @return \AppBundle\Entity\Devise
     */
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Facture
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set isDelete
     *
     * @param integer $isDelete
     *
     * @return Facture
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return integer
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }
}
