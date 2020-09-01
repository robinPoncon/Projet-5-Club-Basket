<?php
namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PagePhotoController extends AbstractController
{
    /**
     * @Route("photos", name="afficherPhotos")
     */
    public function showPhotos(ArticleRepository $articleRepo, EquipeRepository $equipeRepo)
    {
        $articlesNews = $articleRepo->findByCategory(1);
        $articlesTournois = $articleRepo->findByCategory(2);

        $equipesBoy = $equipeRepo->findByType("garçons");
        $equipesGirl = $equipeRepo->findByType("filles");
        $equipesLoisir = $equipeRepo->findByType("loisir");

        return $this->render("photos/showPhotos.html.twig", [
            "articlesNews" => $articlesNews,
            "articlesTournois" => $articlesTournois,
            "equipesBoy" => $equipesBoy,
            "equipesGirl" => $equipesGirl,
            "equipesLoisir" => $equipesLoisir
        ]);
    }

    /**
     * @Route("editor/photos/equipes/data", name="ajax_PhotoEquipe")
     */
    public function ajaxPhotoEquipe(Request $request, EquipeRepository $equipeRepo)
    {
        if($request->isXmlHttpRequest()) {
            // On récupère l'id de la requête
            $idEquipe = $request->request->get('id');
            //dump($idEquipe);

            $equipeObject = $equipeRepo->find($idEquipe);
            // On récupère l'équipe correspondant à l'id

            $photos = $equipeObject->getPhotoEquipes();
            //dump($convocations);

            // On spécifie qu'on utilise un encodeur en json
            $encoders = [new JsonEncoder()];

            // On instancie le "normaliseur" pour convertir la collection en tableau
            $normalizers = [new ObjectNormalizer()];

            // On instancie le convertisseur
            $serializer = new Serializer($normalizers, $encoders);

            // On convertit en json
            $jsonContent = $serializer->serialize($photos, "json", [
                "circular_reference_handler" => function ($object) {
                    return $object->getId();
                }
            ]);

            //dump($jsonContent);

            // On instancie la réponse
            $response = new Response($jsonContent);

            // On ajoute l'entête HTTP
            $response->headers->set("Content-Type", "application/json");

            //dump($response);
            // On envoie la réponse
            return $response;
        }
        else {
            return new Response("erreur");
        }

    }
}