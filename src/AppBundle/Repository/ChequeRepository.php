<?php

namespace AppBundle\Repository;

/**
 * ChequeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChequeRepository extends \Doctrine\ORM\EntityRepository
{
    public function list(
        $agence,
        $type,
        $statut
    )
    {
        $em = $this->getEntityManager();

        $query = "  select c.id, c.num, c.montant, date_format(c.date, '%d/%m/%Y') as date, date_format(c.date_cheque, '%d/%m/%Y') as date_cheque, c.type, c.statut
                    from cheque c
                    inner join agence ag on (c.agence = ag.id)
                    where c.id is not null";

        if ($type) {
            $query .= " and c.type = " . $type;
        }

        if ($agence) {
            $query .= " and c.agence = " . $agence;
        }

        $query .= " and c.statut = " . $statut;

        $statement = $em->getConnection()->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;

    }
}