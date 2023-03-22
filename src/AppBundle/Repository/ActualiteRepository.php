<?php

namespace AppBundle\Repository;

/**
 * ActualiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActualiteRepository extends \Doctrine\ORM\EntityRepository
{
    public function list($cle)
    {
        $em = $this->getEntityManager();
        
        $query = "  select a.id, a.titre, a.description, date_format(a.date,'%d/%m/%Y') as date, a.img
                    from actualite a
                    inner join siteweb si on (a.siteweb = si.id)
                    where a.id is not null ";

        $query .= " and si.cle = '" . $cle . "'";

        $statement = $em->getConnection()->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

    public function details($id)
    {
        $em = $this->getEntityManager();
        
        $query = "  select a.id, a.titre, a.description, date_format(a.date,'%d/%m/%Y') as date, a.img
                    from actualite a
                    inner join siteweb si on (a.siteweb = si.id)
                    where a.id is not null ";

        $query .= " and a.id = " . $id ;

        $statement = $em->getConnection()->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        if (!empty($result)) {
            return $result[0];
        }

        return [];
    }
}
