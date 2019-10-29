<?php
namespace App\Controller;
use App\Entity\Structure;
use App\Entity\Departement;
use App\Entity\Ville;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

class StructureController extends AbstractController
{
    /**
     * @Route("/api/structures/", name="structures")
     */
    public function getStructures(Request $request){
      $longitude = $request->query->get('lg');
      $latitude = $request->query->get('lat');
      $typeStructure = $request->query->get('structure');
      $typeHandicap = $request->query->get('handicap');

      if($typeStructure != NULL)
        $data = $this->getDoctrine()->getRepository(Structure::class)->getTypeStructuresByLocalization($longitude,$latitude, $typeStructure);
      else if($typeHandicap != NULL)
        $data = $this->getDoctrine()->getRepository(Structure::class)->getTypeHandicapByLocalization($longitude,$latitude, $typeHandicap);
      else
       $data = $this->getDoctrine()->getRepository(Structure::class)->getAllStructuresByLocalization($longitude,$latitude);

      return $this->returnSerialize($data);
    }


    /**
     * @Route("/api/ville/", name="ville")
     */
    public function getVille(Request $request){
      $ville = $request->query->get('ville');
      $typeStructure = $request->query->get('structure');
      $typeHandicap = $request->query->get('handicap');

      if($ville != NULL){
        if($typeStructure != NULL)
          $data = $this->getDoctrine()->getRepository(Structure::class)->getTypeStructuresByVille($ville,$typeStructure);
        else if($typeHandicap != NULL)
          $data = $this->getDoctrine()->getRepository(Structure::class)->getTypeHandicapByVille($ville,$typeHandicap);
        else
          $data = $this->getDoctrine()->getRepository(Structure::class)->getAllStructuresByVille($ville);
      }

      return $this->returnSerialize($data);
    }

    /**
     * @Route("/api/departement/", name="departement")
     */
    public function getDepartement(Request $request){
      $departement = $request->query->get('departement');
      $typeStructure = $request->query->get('structure');
      $typeHandicap = $request->query->get('handicap');

      if($departement != NULL){
        if($typeStructure != NULL)
          $data = $this->getDoctrine()->getRepository(Structure::class)->getTypeStructuresByDepartement($departement,$typeStructure);
        else if($typeHandicap != NULL)
          $data = $this->getDoctrine()->getRepository(Structure::class)->getTypeHandicapByDepartement($departement,$typeHandicap);
        else
          $data = $this->getDoctrine()->getRepository(Structure::class)->getAllStructuresByDepartement($departement);
      }

      return $this->returnSerialize($data);
    }


    /**
     * @Route("/api/search-ville/", name="searchVille")
     */
    public function searchVille(Request $request){
      $search = $request->query->get('name');

      if($search != NULL){
        $data = $this->getDoctrine()->getRepository(Ville::class)->searchVille($search);
      }

      return $this->returnSerialize($data);
    }


    /**
     * @Route("/api/search-departement/", name="searchDepartement")
     */
    public function searchDepartement(Request $request){
      $search = $request->query->get('name');

      if($search != NULL){
        $data = $this->getDoctrine()->getRepository(Departement::class)->searchDepartement($search);
      }

      return $this->returnSerialize($data);
    }


    // Return serialized objects
    public function returnSerialize($data){
      $encoders = [new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];

      $serializer = new Serializer($normalizers, $encoders);

      $content = $serializer->serialize($data, 'json', [
          'circular_reference_handler' => function ($object) {
              return $object->getId();
          }
      ]);

      $response = new JsonResponse();
      $response = JsonResponse::fromJsonString($content);

      return $response;
    }
}
