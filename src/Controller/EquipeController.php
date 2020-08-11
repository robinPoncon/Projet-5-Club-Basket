<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\PhotoEquipe;
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
     * @return Response
     */
    public function index(Equipe $equipe)
    {
        $photoEquipes = $equipe->getPhotoEquipes();
        return $this->render("equipe/team.html.twig", [
            'equipe' => $equipe,
            "photoEquipes" => $photoEquipes
        ]);
    }

    /**
     * @Route("editor/equipes", name="equipes")
     * @return Response
     */
    public function show()
    {
        return $this->render("security/editor/compte-equipe.html.twig");
    }

    /**
     * @Route("editor/equipes/ajouter", name="ajouterEquipe")
     */
    public function addTeam(Request $request, EntityManagerInterface $manager)
    {
        $equipe = new Equipe();

        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $photoEquipes = $equipe->getPhotoEquipes();
            foreach($photoEquipes as $key => $photoEquipe){
                $photoEquipe->setEquipe($equipe);
                $photoEquipe->setImportant(0);
                $photoEquipes->set($key,$photoEquipe);
                $manager->persist($photoEquipe);
            }
            $manager->persist($equipe);
            $manager->flush();

            $this->addFlash("success", "L'équipe a bien été ajoutée !");
            return $this->redirectToRoute("equipe", [
                "type" => $equipe->getType(),
                "slug" => $equipe->getSlug()
            ]);
        }

        return $this->render("equipe/add.html.twig", [
            "equipe" => $equipe,
            "formEquipe" => $form->createView()
        ]);

    }

    /**
     * @Route("editor/equipes/modifier/{slug}", name="modifierEquipe")
     */
    public function edit(Equipe $equipe, Request $request, EntityManagerInterface $manager)
    {
        $photoEquipe = $equipe->getPhotoEquipes();

        $form = $this->createForm(EquipeType::class, $equipe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $photoEquipes = $equipe->getPhotoEquipes();
            foreach($photoEquipes as $key => $photoEquipe){
                $photoEquipe->setEquipe($equipe);
                $photoEquipe->setImportant(0);
                $photoEquipes->set($key,$photoEquipe);
                $manager->persist($photoEquipe);
            }
            $manager->persist($equipe);
            $manager->flush();

            $this->addFlash("success", "L'équipe a bien été modifiée !");
            return $this->redirectToRoute("equipe", [
                "type" => $equipe->getType(),
                "slug" => $equipe->getSlug()
            ]);
        }

        return $this->render("equipe/edit.html.twig", [
            "equipe" => $equipe,
            "photoEquipes" => $photoEquipe,
            "formEquipe" => $form->createView()
        ]);
    }

    /**
     * @Route("editor/equipes/mettreEnAvant/photo/{id}", name="mettreEnAvantPhotoEquipe")
     */
    public function mettreEnAvantPhotoEquipe(PhotoEquipe $photoEquipe, Request $request, EntityManagerInterface $manager)
    {
        $equipe = $photoEquipe->getEquipe();
        $photoEquipes = $equipe->getPhotoEquipes();
        foreach($photoEquipes as $photoPasImportante)
        {
            $photoPasImportante->setImportant(0);
            $manager->persist($photoPasImportante);
        }
        $photoEquipe->setImportant(1);
        $manager->persist($photoEquipe);
        $manager->flush();

        $this->addFlash("success", "La photo a bien été mise en avant !");
        return $this->redirectToRoute("modifierEquipe", [
            "slug" => $equipe->getSlug()
        ]);
    }

    /**
     * @Route("editor/equipes/supprimer/photo/{id}", name="supprimerPhotoEquipe")
     */
    public function deletePhoto(PhotoEquipe $photoEquipe, Request $request, EntityManagerInterface $manager)
    {
        $equipe = $photoEquipe->getEquipe();
        $manager->remove($photoEquipe);
        $manager->flush();

        $this->addFlash("success", "La photo a bien été supprimée !");
        return $this->redirectToRoute("modifierEquipe", [
            "slug" => $equipe->getSlug()
        ]);
    }

    /**
     * @Route("editor/equipes/supprimer/{id}", name="supprimerEquipe")
     */
    public function deleteEquipe(Equipe $equipe, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($equipe);
        $manager->flush();

        $this->addFlash("success", "L'équipe a bien été supprimée !");
        return $this->render("security/editor/compte-equipe.html.twig");
    }

}
