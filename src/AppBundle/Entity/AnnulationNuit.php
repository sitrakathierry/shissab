<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnulationNuit
 *
 * @ORM\Table(name="annulation_nuit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnnulationNuitRepository")
 */
class AnnulationNuit
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
     * @var int
     *
     * @ORM\Column(name="nb_nuit", type="integer", nullable=true)
     */
    private $nbNuit;

    /**
     * @var int
     *
     * @ORM\Column(name="ancien_nb_nuit", type="integer", nullable=true)
     */
    private $ancienNbNuit;

    /**
     * @var string
     *
     * @ORM\Column(name="pourcentage", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $pourcentage;

    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ancien_date_sortie", type="datetime", nullable=true)
     */
    private $ancienDateSortie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nouveau_date_sortie", type="datetime", nullable=true)
     */
    private $nouveauDateSortie;

    /**
     * @var \AppBundle\Entity\Booking
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Booking")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="booking", referencedColumnName="id")
     * })
     */
    private $booking;

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
     * Set nbNuit
     *
     * @param integer $nbNuit
     *
     * @return AnnulationNuit
     */
    public function setNbNuit($nbNuit)
    {
        $this->nbNuit = $nbNuit;

        return $this;
    }

    /**
     * Get nbNuit
     *
     * @return int
     */
    public function getNbNuit()
    {
        return $this->nbNuit;
    }

    /**
     * Set pourcentage
     *
     * @param string $pourcentage
     *
     * @return AnnulationNuit
     */
    public function setPourcentage($pourcentage)
    {
        $this->pourcentage = $pourcentage ? $pourcentage : '0.00';

        return $this;
    }

    /**
     * Get pourcentage
     *
     * @return string
     */
    public function getPourcentage()
    {
        return $this->pourcentage;
    }

    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return AnnulationNuit
     */
    public function setMontant($montant)
    {
        $this->montant = $montant ? $montant : '0.00';

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
     * Set ancienDateSortie
     *
     * @param \DateTime $ancienDateSortie
     *
     * @return AnnulationNuit
     */
    public function setAncienDateSortie($ancienDateSortie)
    {
        $this->ancienDateSortie = $ancienDateSortie;

        return $this;
    }

    /**
     * Get ancienDateSortie
     *
     * @return \DateTime
     */
    public function getAncienDateSortie()
    {
        return $this->ancienDateSortie;
    }

    /**
     * Set nouveauDateSortie
     *
     * @param \DateTime $nouveauDateSortie
     *
     * @return AnnulationNuit
     */
    public function setNouveauDateSortie($nouveauDateSortie)
    {
        $this->nouveauDateSortie = $nouveauDateSortie;

        return $this;
    }

    /**
     * Get nouveauDateSortie
     *
     * @return \DateTime
     */
    public function getNouveauDateSortie()
    {
        return $this->nouveauDateSortie;
    }

    /**
     * Set booking
     *
     * @param \AppBundle\Entity\Booking $booking
     *
     * @return AnnulationNuit
     */
    public function setBooking(\AppBundle\Entity\Booking $booking = null)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking
     *
     * @return \AppBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Set ancienNbNuit
     *
     * @param integer $ancienNbNuit
     *
     * @return AnnulationNuit
     */
    public function setAncienNbNuit($ancienNbNuit)
    {
        $this->ancienNbNuit = $ancienNbNuit;

        return $this;
    }

    /**
     * Get ancienNbNuit
     *
     * @return integer
     */
    public function getAncienNbNuit()
    {
        return $this->ancienNbNuit;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AnnulationNuit
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
}
