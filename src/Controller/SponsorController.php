<?php
namespace App\Controller;

use App\Entity\Sponsor;
use App\Form\SponsorType;
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

        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($sponsor);
            $manager->flush();

            $img_nom = $sponsor->getImageName();
            if ($sponsor->getImageName() !== NULL)
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
    public function editSponsor(Sponsor $sponsor, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($sponsor);
            $manager->flush();

            $img_nom = $sponsor->getImageName();
            if ($sponsor->getImageName() !== NULL)
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

            $this->addFlash("success", "Le sponsor a bien été modifié !");
            return $this->redirectToRoute("equipes", [
            ]);
        }

        return $this->render("equipe/sponsor/editSponsor.html.twig", [
            "formSponsor" => $form->createView()
        ]);
    }

    /**
     * @Route("editor/sponsor/supprimer/{id}", name="supprimerSponsor")
     */
    public function deleteSponsor(Sponsor $sponsor, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($sponsor);
        $manager->flush();

        $this->addFlash("success", "Le sponsor a bien été supprimé !");
        return $this->redirectToRoute("equipes");
    }
}