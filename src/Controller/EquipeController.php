<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\PhotoEquipe;
use App\Form\EquipeType;
use App\Form\PhotoEquipesType;
use App\Repository\ConvocationRepository;
use App\Repository\EquipeRepository;
use App\Repository\MemberClubRepository;
use App\Repository\PhotoEquipeRepository;
use App\Repository\PhotoSponsorRepository;
use App\Repository\SponsorRepository;
use App\Repository\UserRepository;
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
    public function index(Equipe $equipe, PhotoEquipeRepository $photoEquipeRepo)
    {
        $photoEquipes = $photoEquipeRepo->findBy(["important" => 0, "equipe" => $equipe->getId()]);
        $photoImportante = $photoEquipeRepo->findOneBy(["important" => 1, "equipe" => $equipe->getId()]);
        return $this->render("equipe/team.html.twig", [
            'equipe' => $equipe,
            "photoEquipes" => $photoEquipes,
            "photoImportante" => $photoImportante
        ]);
    }

    /**
     * @Route("editor/equipes", name="equipes")
     * @return Response
     */
    public function show(MemberClubRepository $memberClubRepository, SponsorRepository $sponsorRepo)
    {
        $memberClubs = $memberClubRepository->findAll();
        $sponsors = $sponsorRepo->findAll();
        return $this->render("security/editor/compte-equipe.html.twig", [
            "memberClubs" => $memberClubs,
            "sponsors" => $sponsors
        ]);
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
            $images = $form->get("images")->getData();

            foreach($images as $image)
            {
                $photo = new PhotoEquipe();
                $photo->setImageFile($image);
                $equipe->addPhotoEquipe($photo);
                $manager->persist($equipe);
            }

            $photoEquipes = $equipe->getPhotoEquipes();
            foreach($photoEquipes as $key => $photoEquipe){
                $photoEquipe->setEquipe($equipe);
                $photoEquipe->setImportant(0);
                $photoEquipes->set($key,$photoEquipe);
                $manager->persist($photoEquipe);

                $img_nom = $photoEquipe->getImageName();
                $extension = strrchr($img_nom, '.');
                if($extension == ".jpeg" || $extension == ".jpg")
                {
                    $img = imagecreatefromjpeg("pictures/equipe/" . $img_nom);
                    imagejpeg($img, "pictures/equipe/" . $img_nom, 50);
                }
                else
                {
                    $img = imagecreatefrompng("pictures/equipe/" . $img_nom);
                    imagepng($img, "pictures/equipe/" . $img_nom, 5);
                }
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
        $allPhotoEquipes = $equipe->getPhotoEquipes();

        $form = $this->createForm(EquipeType::class, $equipe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $images = $form->get("images")->getData();

            foreach($images as $image)
            {
                $photo = new PhotoEquipe();
                $photo->setImageFile($image);
                $equipe->addPhotoEquipe($photo);
                $manager->persist($equipe);
            }

            $photoEquipes = $equipe->getPhotoEquipes();
            foreach($photoEquipes as $key => $photoEquipe){
                $photoEquipe->setEquipe($equipe);
                if($photoEquipe->getImportant() == NULL)
                {
                    $photoEquipe->setImportant(0);
                }
                $photoEquipes->set($key,$photoEquipe);
                $manager->persist($photoEquipe);

                $img_nom = $photoEquipe->getImageName();
                $extension = strrchr($img_nom, '.');

                if($extension == ".jpeg" || $extension == ".jpg")
                {
                    $img = imagecreatefromjpeg("pictures/equipe/" . $img_nom);
                    imagejpeg($img, "pictures/equipe/" . $img_nom, 50);
                }
                else
                {
                    $img = imagecreatefrompng("pictures/equipe/" . $img_nom);
                    imagepng($img, "pictures/equipe/" . $img_nom, 5);
                }
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
            "photoEquipes" => $allPhotoEquipes,
            "formEquipe" => $form->createView()
        ]);
    }

    /**
     * @Route("editor/equipes/modifierPhotoEquipe/{slug}", name="modifierPhotoEquipe")
     */
    public function modifierPhotoEquipe(Equipe $equipe, Request $request, EntityManagerInterface $manager)
    {
        $photoEquipe = new PhotoEquipe();

        $form = $this->createForm(PhotoEquipesType::class, $photoEquipe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $photoEquipes = $equipe->getPhotoEquipes();
            foreach($photoEquipes as $photoPasImportante)
            {
                $photoPasImportante->setImportant(0);
                $manager->persist($photoPasImportante);
            }

            $photoEquipe->setImportant(1);
            $photoEquipe->setEquipe($equipe);

            $manager->persist($photoEquipe);
            $manager->flush();

            $img_nom = $photoEquipe->getImageName();
            $extension = strrchr($img_nom, '.');
            if($extension == ".jpeg" || $extension == ".jpg")
            {
                $img = imagecreatefromjpeg("pictures/equipe/" . $img_nom);
                imagejpeg($img, "pictures/equipe/" . $img_nom, 50);
            }
            else
            {
                $img = imagecreatefrompng("pictures/equipe/" . $img_nom);
                imagepng($img, "pictures/equipe/" . $img_nom, 5);
            }

            $this->addFlash("success", "La photo a bien été mise en avant !");
            return $this->redirectToRoute("equipe", [
                "slug" => $equipe->getSlug(),
                "type" => $equipe->getType()
            ]);
        }

        return $this->render("equipe/photoEquipe.html.twig", [
            "equipe" => $equipe,
            "formPhotoEquipe" => $form->createView()
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
        return $this->redirectToRoute("equipes");
    }

}
