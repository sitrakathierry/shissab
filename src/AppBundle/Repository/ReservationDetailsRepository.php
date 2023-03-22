<?php

namespace AppBundle\Repository;

/**
 * ReservationDetailsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReservationDetailsRepository extends \Doctrine\ORM\EntityRepository
{
    public function consultation($reservation, $type = 0)
    {
        $em = $this->getEntityManager();

        $query = "  select rd.id, p.nom as plat, rd.qte, rd.prix, rd.total, rd.tables, rd.statut, rd.accompagnements, p.id as plat_id, p.type, rd.cuisson
                    from reservation_details rd
                    inner join plat p on (rd.plat = p.id)
                    where rd.id is not null ";
        
        if ($reservation) {
            $query .= " and rd.reservation = " . $reservation ;
        }

        if ($type) {
            if ($type == 1) {
                $query .= " and p.type != 2";
            } else {
                $query .= " and p.type = 2"; 
            }
        }

        $statement = $em->getConnection()->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        if (!empty($result)) {

            $response = [];

            foreach ($result as $value) {
                $tables = json_decode($value['tables']);
                $item = $value;
                $item['tables'] = array();

                $accompagnementsDetails = $this->accompagnementsDetails($value['accompagnements']);
                $item['accompagnements'] = $accompagnementsDetails['accompagnements'];
                $item['total_accompagnement'] = $accompagnementsDetails['total_accompagnement'];

                if (is_array($tables)) {

                    foreach ($tables as $table_id) {

                        if ($table_id) {
                            $q = "  select *
                                    from table_restaurant t
                                    where t.id = " . $table_id;

                            $s = $em->getConnection()->prepare($q);
                            $s->execute();
                            $r = $s->fetchAll();

                            if (!empty($r)) {
                                $table = $r[0];
                                array_push($item['tables'], $table['nom']);
                            }
                        }


                    }
                }


                array_push($response, $item);
            }

            return $response;
        }

        return [];
    }

    public function accompagnementsDetails($accompagnements)
    {

        $data = [];


        $accompagnements = json_decode($accompagnements, true);

        if (is_array($accompagnements)) {
            $accompagnement_list = array_key_exists('accompagnement', $accompagnements) ? $accompagnements['accompagnement'] : [];
            $qte_accompagnement_list = array_key_exists('qte_accompagnement', $accompagnements) ? $accompagnements['qte_accompagnement'] : [];
            $prix_accompagnement_list = array_key_exists('prix_accompagnement', $accompagnements) ? $accompagnements['prix_accompagnement'] : [];
            $total_accompagnement = array_key_exists('total_accompagnement', $accompagnements) ? $accompagnements['total_accompagnement'] : '0.00';

            foreach ($accompagnement_list as $key => $value) {
                $item = array(
                    'accompagnement' => $accompagnement_list[$key],
                    'qte_accompagnement' => $qte_accompagnement_list[$key],
                    'prix_accompagnement' => $prix_accompagnement_list[$key],
                );

                array_push($data, $item);
            }

            return array(
                'accompagnements' => $data,
                'total_accompagnement' => $total_accompagnement,
            );
        }

        return array(
            'accompagnements' => $data,
            'total_accompagnement' => 0,
        );


    }
}