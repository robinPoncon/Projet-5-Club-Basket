<?php
namespace App\Controller;

use App\Entity\PhotoSponsor;
use App\Entity\Sponsor;
use App\Form\PhotoSponsorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SponsorController extends AbstractController
{

    /**
     * @Route("editor/sponsor/ajouter", name="ajouterSponsor")
     */
    public function addSponsor(Request $request, EntityManagerInterface $manager)
    {
        $sponsor = new Sponsor();

        $form = $this->createForm(PhotoSponsorType::class, $sponsor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $images = $form->get("images")->getData();

            foreach($images as $image)
            {
                $photo = new PhotoSponsor();
                $photo->setImageFile($image);
                $sponsor->addPhotoSponsor($photo);
                $manager->persist($sponsor);
            }
            $manager->flush();

            $photoSponsors = $sponsor->getPhotoSponsor();
            foreach($photoSponsors as $key => $photoSponsor)
            {
                $img_nom = $photoSponsor->getImageName();
                if ($photoSponsor->getImageName() !== NULL)
                {
                    $extension = strrchr($img_nom, '.');
                    if($extension == ".jpeg" || $extension == ".jpg")
                    {
                        $img = imagecreatefromjpeg("pictures/sponsor/" . $img_nom);
                        imagejpeg($img, "pictures/sponsor/" . $img_nom, 50);
                    }
                    else
                    {
                        $img = imagecreatefrompng("pictures/sponsor/" . $img_nom);
                        imagepng($img, "pictures/sponsor/" . $img_nom, 5);
                    }
                }
            }

            $this->addFlash("success", "Le sponsor a bien été ajouté !");
            return $this->redirectToRoute("equipes", [
            ]);
        }

        return $this->render("equipe/sponsor/addSponsor.html.twig", [
            "formSponsor" => $form->createView()
        ]);
    }

    /**
     * @Route("editor/sponsor/modifier/{id}", name="modifierSponsor")
     */
    public function editSponsor(sponsor $sponsor, Request $request, EntityManagerInterface $manager)
    {
        $photoSponsors = $sponsor->getPhotoSponsor();

        $form = $this->createForm(PhotoSponsorType::class, $sponsor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $images = $form->get("images")->getData();

            foreach($images as $image)
            {
                $photo = new PhotoSponsor();
                $photo->setImageFile($image);
                $sponsor->addPhotoSponsor($photo);
                $manager->persist($sponsor);
            }
            $manager->flush();

            foreach($photoSponsors as $key => $photoSponsor)
            {
                $img_nom = $photoSponsor->getImageName();
                if ($photoSponsor->getImageName() !== NULL)
                {
                    $extension = strrchr($img_nom, '.');
                    if($extension == ".jpeg" || $extension == ".jpg")
                    {
                        $img = imagecreatefromjpeg("pictures/sponsor/" . $img_nom);
                        imagejpeg($img, "pictures/sponsor/" . $img_nom, 50);
                    }
                    else
                    {
                        $img = imagecreatefrompng("pictures/sponsor/" . $img_nom);
                        imagepng($img, "pictures/sponsor/" . $img_nom, 5);
                    }
                }
            }

            $this->addFlash("success", "Le sponsor a bien été modifié !");
            return $this->redirectToRoute("equipes", [
            ]);
        }

        return $this->render("equipe/sponsor/editSponsor.html.twig", [
            "formSponsor" => $form->createView(),
            "photoSponsors" => $photoSponsors
        ]);
    }

    /**
     * @Route("editor/sponsor/supprimer/{id}", name="supprimerPhotoSponsor")
     */
    public function deletePhotoSponsor(PhotoSponsor $photoSponsor, Request $request, EntityManagerInterface $manager)
    {
        $sponsor = $photoSponsor->getSponsor();
        $manager->remove($photoSponsor);
        $manager->flush();

        $this->addFlash("success", "La photo du sponsor a bien été supprimée !");
        return $this->redirectToRoute("modifierSponsor", [
            "id" => $sponsor->getId()
        ]);
    }
}