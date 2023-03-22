<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntreeSortieStockInterneDetails
 *
 * @ORM\Table(name="entree_sortie_stock_interne_details")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntreeSortieStockInterneDetailsRepository")
 */
class EntreeSortieStockInterneDetails
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="qte", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $qte;

    /**
     * @var string
     *
     * @ORM\Column(name="portion", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $portion;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \AppBundle\Entity\StockInterne
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\StockInterne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="stock_interne", referencedColumnName="id")
     * })
     */
    private $stockInterne;

    /**
     * @var \AppBundle\Entity\EntreeSortieStockInterne
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EntreeSortieStockInterne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entree_sortie_stock_interne", referencedColumnName="id")
     * })
     */
    private $entreeSortieStockInterne;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return EntreeSortieStockInterneDetails
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
     * Set qte
     *
     * @param string $qte
     *
     * @return EntreeSortieStockInterneDetails
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return string
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return EntreeSortieStockInterneDetails
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return EntreeSortieStockInterneDetails
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
     * Set description
     *
     * @param string $description
     *
     * @return EntreeSortieStockInterneDetails
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set stockInterne
     *
     * @param \AppBundle\Entity\StockInterne $stockInterne
     *
     * @return EntreeSortieStockInterneDetails
     */
    public function setStockInterne(\AppBundle\Entity\StockInterne $stockInterne = null)
    {
        $this->stockInterne = $stockInterne;

        return $this;
    }

    /**
     * Get stockInterne
     *
     * @return \AppBundle\Entity\StockInterne
     */
    public function getStockInterne()
    {
        return $this->stockInterne;
    }

    /**
     * Set entreeSortieStockInterne
     *
     * @param \AppBundle\Entity\EntreeSortieStockInterne $entreeSortieStockInterne
     *
     * @return EntreeSortieStockInterneDetails
     */
    public function setEntreeSortieStockInterne(\AppBundle\Entity\EntreeSortieStockInterne $entreeSortieStockInterne = null)
    {
        $this->entreeSortieStockInterne = $entreeSortieStockInterne;

        return $this;
    }

    /**
     * Get entreeSortieStockInterne
     *
     * @return \AppBundle\Entity\EntreeSortieStockInterne
     */
    public function getEntreeSortieStockInterne()
    {
        return $this->entreeSortieStockInterne;
    }

    /**
     * Set portion
     *
     * @param string $portion
     *
     * @return EntreeSortieStockInterneDetails
     */
    public function setPortion($portion)
    {
        $this->portion = $portion;

        return $this;
    }

    /**
     * Get portion
     *
     * @return string
     */
    public function getPortion()
    {
        return $this->portion;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return EntreeSortieStockInterneDetails
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
}
