<?php

namespace App\Controller;

use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api", name="api_")
 *
 */
class APIController extends AbstractController
{
    /**
     * @Route("/equipes/liste", name="liste", methods={"GET"})
     */
    public function liste(EquipeRepository $equipeRepository)
    {
        // On récupère la liste des équipes
        $equipes = $equipeRepository->apiFindAll();

        // On spécifie qu'on utilise un encodeur en json
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

            // On fait la conversion en json
        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($equipes, "json", [
            "circular_reference_handler" => function($object){
                return $object->getId();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set("Content-Type", "application/json");

        // On envoie la réponse
        return $response;

    }
}
