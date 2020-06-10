<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\ConvocationRepository;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    /**
     * @Route("equipe/{type}/{slug}", name="equipe")
     * @param Equipe $equipe
     * @param ConvocationRepository $convocationRepository
     * @return Response
     */
    public function index(Equipe $equipe, ConvocationRepository $convocationRepository)
    {
        $convocations = $convocationRepository->findByEquipesId($equipe->getId());
        return $this->render("equipe/team.html.twig", [
            'equipe' => $equipe,
            "convocations" => $convocations
        ]);
    }

    /**
     * @Route("admin/equipes", name="equipes")
     * @return Response
     */
    public function findAll()
    {
        return $this->render("security/admin/compte-equipe.html.twig");
    }

    /**
     * @Route("admin/equipes/modifier/{slug}", name="modifierEquipe")
     */
    public function edit(Equipe $equipe, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EquipeType::class, $equipe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($equipe);
            $manager->flush();

            return $this->redirectToRoute("equipes");
        }

        return $this->render("equipe/edit.html.twig", [
            "equipe" => $equipe,
            "formEquipe" => $form->createView()
        ]);
    }

}
