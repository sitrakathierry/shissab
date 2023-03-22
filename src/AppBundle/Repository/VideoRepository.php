<?php

namespace AppBundle\Repository;

/**
 * VideoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideoRepository extends \Doctrine\ORM\EntityRepository
{
    public function list($cle)
    {
        $em = $this->getEntityManager();
        
        $query = "  select v.id, v.titre, v.url
                    from video v
                    inner join siteweb si on (v.siteweb = si.id)
                    where v.id is not null ";

        $query .= " and si.cle = '" . $cle  . "'";

        $statement = $em->getConnection()->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }
}
