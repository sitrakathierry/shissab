<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaiementCredit
 *
 * @ORM\Table(name="paiement_credit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaiementCreditRepository")
 */
class PaiementCredit
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
     * @ORM\Column(name="montant", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return PaiementCredit
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PaiementCredit
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
     * Set credit
     *
     * @param \AppBundle\Entity\Credit $credit
     *
     * @return PaiementCredit
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
}
