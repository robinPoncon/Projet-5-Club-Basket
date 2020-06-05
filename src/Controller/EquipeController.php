<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    /**
     * @Route("equipe/{type}/{name}", name="equipe")
     * @param Equipe $equipe
     * @return Response
     */
    public function index(Equipe $equipe)
    {

        return $this->render("equipe/team.html.twig", [
            'equipe' => $equipe
        ]);
    }

    /**
     * @Route("compte/equipes", name="equipes")
     * @param EquipeRepository $repository
     * @return Response
     */
    public function findAll(EquipeRepository $repository)
    {
        $equipes = $repository->findAll();
        return $this->render("security/compte/compte-equipe.html.twig", [
           "equipes" => $equipes
        ]);

    }

    /**
     * @Route("compte/equipes/modifier/{id}", name="modifierEquipe")
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
