<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VariationProduit
 *
 * @ORM\Table(name="variation_produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VariationProduitRepository")
 */
class VariationProduit
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
     * @ORM\Column(name="prix_vente", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $prixVente;

    /**
     * @var string
     *
     * @ORM\Column(name="stock", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $stock;

    /**
     * @var \AppBundle\Entity\ProduitEntrepot
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProduitEntrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit_entrepot", referencedColumnName="id")
     * })
     */
        
    private $produitEntrepot;

    /**
     * @var \AppBundle\Entity\Produit
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produitId", referencedColumnName="id")
     * })
     */
    
    private $produitId ;
    /**
     * @var integer
     *
     * @ORM\Column(name="marge_type", type="integer", nullable=true)
     */
    private $margeType = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="marge_valeur", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $margeValeur;

    /**
     * @var int
     *
     * @ORM\Column(name="is_delete", type="integer", nullable=true)
     */
    private $is_delete;

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
     * Set prixVente
     *
     * @param string $prixVente
     *
     * @return VariationProduit
     */
    public function setPrixVente($prixVente)
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    /**
     * Get prixVente
     *
     * @return string
     */
    public function getPrixVente()
    {
        return $this->prixVente;
    }

    /**
     * Set stock
     *
     * @param string $stock
     *
     * @return VariationProduit
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return string
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set produitEntrepot
     *
     * @param \AppBundle\Entity\ProduitEntrepot $produitEntrepot
     *
     * @return VariationProduitEntrepot
     */
    public function setProduitEntrepot(\AppBundle\Entity\ProduitEntrepot $produitEntrepot = null)
    {
        $this->produitEntrepot = $produitEntrepot;

        return $this;
    }

    /**
     * Get produitEntrepot
     *
     * @return \AppBundle\Entity\ProduitEntrepot
     */

    public function getProduitEntrepot()
    {
        return $this->produitEntrepot;
    }
    
    /**
     * Set produit
     *
     * @param \AppBundle\Entity\Produit $produitId
     *
     * @return VariationProduit
     */
    public function setproduitId($produitId)
    {
        $this->produitId = $produitId ; 

        return $this ;
    }

    /**
     * Get produit
     *
     * @return \AppBundle\Entity\Produit
     */
    public function getproduitId()
    {
        return $this->produitId ;
    }
    /**
     * Set margeType
     *
     * @param integer $margeType
     *
     * @return VariationProduit
     */
    public function setMargeType($margeType)
    {
        $this->margeType = $margeType;

        return $this;
    }

    /**
     * Get margeType
     *
     * @return integer
     */
    public function getMargeType()
    {
        return $this->margeType;
    }

    /**
     * Set margeValeur
     *
     * @param string $margeValeur
     *
     * @return VariationProduit
     */
    public function setMargeValeur($margeValeur)
    {
        $this->margeValeur = $margeValeur ? $margeValeur : '0.00';

        return $this;
    }

    /**
     * Get margeValeur
     *
     * @return string
     */
    public function getMargeValeur()
    {
        return $this->margeValeur;
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
