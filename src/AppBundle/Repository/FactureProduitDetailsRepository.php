<?php

namespace AppBundle\Repository;

/**
 * FactureProduitDetailsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FactureProduitDetailsRepository extends \Doctrine\ORM\EntityRepository
{
    public function recette($recherche_par,$a_rechercher,$type_date, $mois, $annee, $date_specifique, $debut_date, $fin_date, $par_agence = 0)
    {

        $em = $this->getEntityManager();

        $query = "  select date_format(f.date_creation,'%d/%m/%Y') as date_creation, date_format(f.date,'%d/%m/%Y') as date, IF(c.statut = 1,cm.nom_societe,cp.nom) as client, CONCAT( IF(f.type = 1, 'PR-','DF-') ,LPAD(f.num, 3, '0'),'/',date_format(f.date_creation,'%y')) as num_fact, fpd.montant as total, p.nom as produit
                    from facture_produit_details fpd
                    inner join facture_produit fp on (fpd.facture_produit = fp.id)
                    inner join facture f on (fp.facture = f.id)
                    inner join variation_produit vp on (fpd.variation_produit = vp.id)
                    inner join produit_entrepot pe on (vp.produit_entrepot = pe.id)
                    left join entrepot e on (pe.entrepot = e.id)
                    inner join produit p on (pe.produit = p.id)
                    left join client c on (f.client = c.num_police)
                    left join client_morale cm on (c.id_client_morale=cm.id)
                    left join client_physique cp on (c.id_client_physique=cp.id)
                    inner join agence ag on (f.agence = ag.id)
                    ";

        $where = " where f.id is not null";

        $where .= " and f.type = 2";

        if($recherche_par == 1){
            $where .= " and (cm.nom_societe LIKE '%" . $a_rechercher . "%'";

            $where .= " or cp.nom LIKE '%" . $a_rechercher . "%')";

            // $where .= "  or f.nom LIKE '%" . $a_rechercher . "%')";
        }

        if ($recherche_par == 2) {
            $where .= " and CONCAT(IF(f.type = 1, 'PR-','DF-'),LPAD(f.num, 3, '0'),'/',date_format(f.date_creation,'%y')) like '%". $a_rechercher ."%'";
        }

        if ($recherche_par == 3) {
            $where .= " and f.police like '%". $a_rechercher ."%'";
        }

        if ($par_agence != 0) {
            $where .= " and ag.id = " . $par_agence;
        }

        if ($type_date) {
            switch ($type_date) {
                case '1':
                    $now = new \DateTime();
                    $dateNow = $now->format('d-m-Y');
                    $where .= " and date_format(f.date_creation,'%d-%m-%Y') = '" . $dateNow ."'";
                    break;
                
                case '2':
                    $moisAnnee = $mois . "-" . $annee;
                    $where .= " and date_format(f.date_creation,'%m-%Y') = '" . $moisAnnee ."'";
                    break;

                case '3':
                    $where .= " and date_format(f.date_creation,'%Y') = '" . $annee ."'";
                    break;

                case '4':
                    // $date = \DateTime::createFromFormat('j/m/Y', $date_specifique);
                    $where .= " and date_format(f.date_creation,'%d/%m/%Y') = '" . $date_specifique ."'";
                    break;

                case '5':
                    $where .= " and date_format(f.date_creation,'%d/%m/%Y') >= '" . $debut_date ."'";
                    $where .= " and date_format(f.date_creation,'%d/%m/%Y') <= '" . $fin_date ."'";
                    break;
            }
        }


        $query .= $where;

        $statement = $em->getConnection()->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

    public function getFactureProduitDetails($factureDetail)
    {
        $sql = "SELECT distinct p.*, vp.stock, fp.commande, pe.indice, vp.id as vpId, fpd.* FROM `facture_produit_details` fpd 
                JOIN facture_produit fp ON fp.id = fpd.facture_produit
                JOIN commande c ON c.id = fp.commande
                LEFT JOIN pannier pn ON pn.commande = c.id
                LEFT JOIN variation_produit vp ON pn.variation_produit = vp.id
                JOIN produit_entrepot pe ON pe.id = vp.produit_entrepot 
                JOIN produit p ON p.id = pe.produit 
                WHERE fpd.id = ? ";

        $em = $this->getEntityManager();
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute(array($factureDetail));
        $result = $statement->fetch();

        return $result;
    }
    
    public function findVariationByCredit($idCredit)
    {
        $sql = " SELECT fpd.designation FROM `facture` f 
                        JOIN facture_produit fp ON f.id = fp.facture 
                        LEFT JOIN facture_produit_details fpd ON fp.id = fpd.facture_produit 
                        WHERE f.credit = ? ";
        $em = $this->getEntityManager();
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute(array($idCredit));
        $result = $statement->fetchAll();
        return $result;
    }
}
