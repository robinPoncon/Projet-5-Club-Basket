<?php

namespace App\Controller;

use App\Entity\Convocation;
use App\Entity\Equipe;
use App\Form\ConvocationType;
use App\Repository\ConvocationRepository;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConvocationController extends AbstractController
{
    /**
     * @Route("admin/equipes/entrainement", name="entrainement")
     */
    public function index()
    {
        return $this->render('equipe/convocation/index-convoc.html.twig', [

        ]);

    }

    /**
     * @Route("admin/equipes/entrainement/ajouter", name="ajouterEntrainement")
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
}
