<?php

namespace App\Controller;

use App\Entity\Convocation;
use App\Entity\Equipe;
use App\Form\ConvocationType;
use App\Repository\ConvocationRepository;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ConvocationController extends AbstractController
{
    /**
     * @Route("admin/equipes/entrainement", name="entrainement")
     */
    public function index(EquipeRepository $equipeRepo)
    {
        $equipesBoy = $equipeRepo->findByType("garçons");
        $equipesGirl = $equipeRepo->findByType("filles");
        return $this->render('equipe/convocation/index-convoc.html.twig', [
            "equipesBoy" => $equipesBoy,
            "equipesGirl" => $equipesGirl
        ]);

    }

    /**
     * @Route("admin/equipes/entrainements/data", name="ajax_equipe")
     */
    public function ajaxConvoc(Request $request, ConvocationRepository $convocRepo)
    {
            if($request->isXmlHttpRequest()) {
                // On récupère l'id de la requête
                $idEquipe = $request->request->get('id');
                //dump($idEquipe);
                // On récupère l'équipe correspondant à l'id
                $convocations = $convocRepo->findIdEquipe($idEquipe);
                //dump($convocations);
                // On spécifie qu'on utilise un encodeur en json
                $encoders = [new JsonEncoder()];

                // On instancie le "normaliseur" pour convertir la collection en tableau
                $normalizers = [new ObjectNormalizer()];

                // On instancie le convertisseur
                $serializer = new Serializer($normalizers, $encoders);

                // On convertit en json
                $jsonContent = $serializer->serialize($convocations, "json", [
                    "circular_reference_handler" => function ($object) {
                        return $object->getId();
                    }
                ]);

                //dump($jsonContent);

                // On instancie la réponse
                $response = new Response($jsonContent);

                // On ajoute l'entête HTTP
                $response->headers->set("Content-Type", "application/json");

                dump($response);
                // On envoie la réponse
                return $response;
            }
            else {
                return new Response("erreur");
            }

    }

    /**
     * @Route("admin/equipes/entrainements/ajouter", name="ajouterEntrainement")
     */

    public function addConvocation(Request $request, EntityManagerInterface $manager)
    {
        $convocation = new Convocation();

        $form = $this->createForm(ConvocationType::class, $convocation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($convocation);
            $manager->flush();

            return $this->redirectToRoute("entrainement");
        }

        return $this->render("equipe/convocation/add-convoc.html.twig", [
            "formConvoc" => $form->createView()
        ]);
    }

    /**
     * @Route("admin/equipes/entrainements/{id}", name="modifierEntrainement")
     */
    public function edit(Convocation $convocation, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ConvocationType::class, $convocation);
        $form->handleRequest($request);

        $equipe = $convocation->getEquipes();

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($convocation);
            $manager->flush();

            return $this->redirectToRoute("entrainement");
        }

        return $this->render("equipe/convocation/edit-convoc.html.twig", [
            "formConvoc" => $form->createView(),
            "equipe" => $equipe
        ]);
    }

    /**
     * @Route("admin/equipes/entrainements/delete/{id}", name="supprimerEntrainement")
     */
    public function delete(Request $request, EntityManagerInterface $manager, Convocation $convocation)
    {
        $manager->remove($convocation);
        $manager->flush();

        return $this->redirectToRoute("entrainement");
    }
}
