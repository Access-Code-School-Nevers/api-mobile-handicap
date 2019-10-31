<?php

namespace App\Repository;

use App\Entity\Structure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Structure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Structure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Structure[]    findAll()
 * @method Structure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Structure::class);
    }

    // /**
    //  * @return Structure[] Returns an array of Structure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Structure
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


  /* FUNCTIONS TO GET STRUCTURES BY GEOLOCALIZATION */
  // Return all structures at 50km around a specified localization
  public function getAllStructuresByLocalization($lg,$lat){
    if(is_numeric($lg) && is_numeric($lat)){
      $rad = 50;
      $R = 6371;

      $maxLat = $lat + rad2deg($rad/$R);
      $minLat = $lat - rad2deg($rad/$R);
      $maxLon = $lg + rad2deg(asin($rad/$R) / cos(deg2rad($lat)));
      $minLon = $lg - rad2deg(asin($rad/$R) / cos(deg2rad($lat)));

      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
              FROM structure
              LEFT JOIN handicap ON structure.id = handicap.structure_id_id
              LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
              WHERE Latitude BETWEEN :minLat AND :maxLat AND Longitude BETWEEN :minLon AND :maxLon
              GROUP BY structure.id";


      // PDO to escape values to avoid injections
      $stmt = $conn->prepare($sql);
      $stmt->execute(['minLon' => $minLon, 'maxLon' => $maxLon, 'minLat' => $minLat, 'maxLat' => $maxLat]);

      // returns an array of arrays (i.e. a raw data set)
      return $stmt->fetchAll();
    }
    else return false;
  }

  // Return structures at 50km around a specified localization by type structure
  public function getTypeStructuresByLocalization($lg,$lat,$typeStructure){
    if(is_numeric($lg) && is_numeric($lat)){
      $rad = 50;
      $R = 6371;

      $addRequest = $this->dispatchRequest($typeStructure,'type_structure');

      $maxLat = $lat + rad2deg($rad/$R);
      $minLat = $lat - rad2deg($rad/$R);
      $maxLon = $lg + rad2deg(asin($rad/$R) / cos(deg2rad($lat)));
      $minLon = $lg - rad2deg(asin($rad/$R) / cos(deg2rad($lat)));

      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
              FROM structure
              LEFT JOIN handicap ON structure.id = handicap.structure_id_id
              LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
              WHERE Latitude BETWEEN :minLat AND :maxLat AND Longitude BETWEEN :minLon AND :maxLon
              AND structure.id IN (SELECT structure.id
                                   FROM structure
                                   LEFT JOIN handicap ON structure.id = handicap.structure_id_id
                                   WHERE $addRequest
                                   GROUP BY structure.id)
              GROUP BY structure.id";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['minLon' => $minLon, 'maxLon' => $maxLon, 'minLat' => $minLat, 'maxLat' => $maxLat]);

      // returns an array of arrays (i.e. a raw data set)
      return $stmt->fetchAll();
    }
    else return false;
  }

  // Return structures at 50km around a specified localization by handicap type
  public function getTypeHandicapByLocalization($lg,$lat,$typeHandicap){
    if(is_numeric($lg) && is_numeric($lat)){
      $rad = 50;
      $R = 6371;

      $addRequest = $this->dispatchRequest($typeHandicap,'handicap.type_handicap_id_id');

      $maxLat = $lat + rad2deg($rad/$R);
      $minLat = $lat - rad2deg($rad/$R);
      $maxLon = $lg + rad2deg(asin($rad/$R) / cos(deg2rad($lat)));
      $minLon = $lg - rad2deg(asin($rad/$R) / cos(deg2rad($lat)));

      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
              FROM structure
              LEFT JOIN handicap ON structure.id = handicap.structure_id_id
              LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
              WHERE Latitude BETWEEN :minLat AND :maxLat AND Longitude BETWEEN :minLon AND :maxLon
              AND structure.id IN (SELECT structure.id
                                   FROM structure
                                   LEFT JOIN handicap ON structure.id = handicap.structure_id_id
                                   WHERE $addRequest
                                   GROUP BY structure.id)
              GROUP BY structure.id";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['minLon' => $minLon, 'maxLon' => $maxLon, 'minLat' => $minLat, 'maxLat' => $maxLat]);

      // returns an array of arrays (i.e. a raw data set)
      return $stmt->fetchAll();
    }
    else return false;
  }



  /* FUNCTION TO GET STRUCTURES BY A SPECIFIED CITY */
  // Return structures at 50km around a specified city
  public function getAllStructuresByVille($ville){
    $ville = urldecode($ville);

    if($ville != ""){
      $rad = 50;
      $R = 6371;

      $conn = $this->getEntityManager()->getConnection();

      // Get coordinates of the city
      $row = $this->getCity($conn,$ville);

      if($row != false){
        $lat = $row['latitude'];
        $lg = $row['longitude'];

        // Get all structures around the city
        $maxLat = $lat + rad2deg($rad/$R);
        $minLat = $lat - rad2deg($rad/$R);
        $maxLon = $lg + rad2deg(asin($rad/$R) / cos(deg2rad($lat)));
        $minLon = $lg - rad2deg(asin($rad/$R) / cos(deg2rad($lat)));

        $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
                FROM structure
                LEFT JOIN handicap ON structure.id = handicap.structure_id_id
                LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
                WHERE Latitude BETWEEN :minLat AND :maxLat AND Longitude BETWEEN :minLon AND :maxLon
                GROUP BY structure.id";

        $stmt2 = $conn->prepare($sql);
        $stmt2->execute(['minLon' => $minLon, 'maxLon' => $maxLon, 'minLat' => $minLat, 'maxLat' => $maxLat]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt2->fetchAll();
      }
      else return false;
    }
    else return false;
  }

  // Return structures at 50km around a specified city, filtered by type structure
  public function getTypeStructuresByVille($ville,$typeStructure){
    $ville = urldecode($ville);

    if($ville != ""){
      $rad = 50;
      $R = 6371;

      $conn = $this->getEntityManager()->getConnection();

      // Get coordinates of the city
      $row = $this->getCity($conn,$ville);

      if($row != false){
        $lat = $row['latitude'];
        $lg = $row['longitude'];

        $addRequest = $this->dispatchRequest($typeStructure,'type_structure');

        // Get all structures around the city
        $maxLat = $lat + rad2deg($rad/$R);
        $minLat = $lat - rad2deg($rad/$R);
        $maxLon = $lg + rad2deg(asin($rad/$R) / cos(deg2rad($lat)));
        $minLon = $lg - rad2deg(asin($rad/$R) / cos(deg2rad($lat)));

        $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
                FROM structure
                LEFT JOIN handicap ON structure.id = handicap.structure_id_id
                LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
                WHERE Latitude BETWEEN :minLat AND :maxLat AND Longitude BETWEEN :minLon AND :maxLon
                AND structure.id IN (SELECT structure.id
                                     FROM structure
                                     LEFT JOIN handicap ON structure.id = handicap.structure_id_id
                                     WHERE $addRequest
                                     GROUP BY structure.id)
                GROUP BY structure.id";

        $stmt2 = $conn->prepare($sql);
        $stmt2->execute(['minLon' => $minLon, 'maxLon' => $maxLon, 'minLat' => $minLat, 'maxLat' => $maxLat]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt2->fetchAll();
      }
      else return false;
    }
    else return false;
  }

  // Return structures at 50km around a specified city, filtered by type structure
  public function getTypeHandicapByVille($ville,$typeHandicap){
    $ville = urldecode($ville);

    if($ville != ""){
      $rad = 50;
      $R = 6371;

      $conn = $this->getEntityManager()->getConnection();

      // Get coordinates of the city
      $row = $this->getCity($conn,$ville);

      if($row != false){
        $lat = $row['latitude'];
        $lg = $row['longitude'];

        $addRequest = $this->dispatchRequest($typeHandicap,'handicap.type_handicap_id_id');

        // Get all structures around the city
        $maxLat = $lat + rad2deg($rad/$R);
        $minLat = $lat - rad2deg($rad/$R);
        $maxLon = $lg + rad2deg(asin($rad/$R) / cos(deg2rad($lat)));
        $minLon = $lg - rad2deg(asin($rad/$R) / cos(deg2rad($lat)));

        $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
                FROM structure
                LEFT JOIN handicap ON structure.id = handicap.structure_id_id
                LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
                WHERE Latitude BETWEEN :minLat AND :maxLat AND Longitude BETWEEN :minLon AND :maxLon
                AND structure.id IN (SELECT structure.id
                                     FROM structure
                                     LEFT JOIN handicap ON structure.id = handicap.structure_id_id
                                     WHERE $addRequest
                                     GROUP BY structure.id)
                GROUP BY structure.id";

        $stmt2 = $conn->prepare($sql);
        $stmt2->execute(['minLon' => $minLon, 'maxLon' => $maxLon, 'minLat' => $minLat, 'maxLat' => $maxLat]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt2->fetchAll();
      }
      else return false;
    }
    else return false;
  }



  /* FUNCTIONS TO GET STRUCTURES OF A SPECIFIED DEPARTMENT */
  // Return structures of a selected department
  public function getAllStructuresByDepartement($departement){
    if(is_numeric($departement)){
      $conn = $this->getEntityManager()->getConnection();

      // Get coordinates of the city
      $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
              FROM structure
              LEFT JOIN departement ON structure.code_departement_id = departement.id
              LEFT JOIN handicap ON structure.id = handicap.structure_id_id
              LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
              WHERE departement.code = :departement
              GROUP BY structure.id";
      $stmt = $conn->prepare($sql);
      $stmt->execute(['departement' => $departement]);

      return $stmt->fetchAll();
    }
    else return false;
  }

  // Return structures of a selected department filtered by type structure
  public function getTypeStructuresByDepartement($departement,$typeStructure){
    if(is_numeric($departement)){
      $addRequest = $this->dispatchRequest($typeStructure,'type_structure');

      $conn = $this->getEntityManager()->getConnection();

      // Get coordinates of the city
      $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
              FROM structure
              LEFT JOIN departement ON structure.code_departement_id = departement.id
              LEFT JOIN handicap ON structure.id = handicap.structure_id_id
              LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
              WHERE departement.code = :departement
              AND structure.id IN (SELECT structure.id
                                   FROM structure
                                   LEFT JOIN departement ON structure.code_departement_id = departement.id
                                   LEFT JOIN handicap ON structure.id = handicap.structure_id_id
                                   WHERE departement.code = :departement AND $addRequest
                                   GROUP BY structure.id)
              GROUP BY structure.id";
      $stmt = $conn->prepare($sql);
      $stmt->execute(['departement' => $departement]);

      return $stmt->fetchAll();
    }
    else return false;
  }

  // Return structures of a selected department filtered by type structure
  public function getTypeHandicapByDepartement($departement,$typeHandicap){
    if(is_numeric($departement)){
      $addRequest = $this->dispatchRequest($typeHandicap,'handicap.type_handicap_id_id');

      $conn = $this->getEntityManager()->getConnection();

      // Get coordinates of the city
      $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
              FROM structure
              LEFT JOIN departement ON structure.code_departement_id = departement.id
              LEFT JOIN handicap ON structure.id = handicap.structure_id_id
              LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
              WHERE departement.code = :departement
              AND structure.id IN (SELECT structure.id
                                   FROM structure
                                   LEFT JOIN departement ON structure.code_departement_id = departement.id
                                   LEFT JOIN handicap ON structure.id = handicap.structure_id_id
                                   WHERE departement.code = :departement AND $addRequest
                                   GROUP BY structure.id)
              GROUP BY structure.id";
      $stmt = $conn->prepare($sql);
      $stmt->execute(['departement' => $departement]);

      return $stmt->fetchAll();
    }
    else return false;
  }




  // Get information of a city
  public function getCity($conn,$ville){
    $sql = "SELECT *
            FROM ville
            WHERE nom = :nomVille";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['nomVille' => $ville]);
    $row = $stmt->fetch();

    return $row;
  }

  // Return data of structure/handicap parsed to create the request
  public function dispatchRequest($data,$type){
    $data = explode('-',$data);
    $nbStructures = count($data);
    $addRequest = '';

    // if multiple structures passed to request, we add them to query
    $addRequest .= '(';
    for($i=0 ; $i<$nbStructures ; $i++){
      $addRequest .= ' '.$type.' = '.(int)$data[$i].' OR';
    }
    $addRequest = substr($addRequest,0,-3);
    $addRequest .= ')';

    return $addRequest;
  }
}
