<?php
namespace App\Controller;

use App\Entity\MemberClub;
use App\Form\MemberClubType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembreClubController extends AbstractController
{
    /**
     * @Route("editor/membreClub/afficher/{id}", name="pageMembre")
     */
    public function pageMembre(MemberClub $memberClub)
    {
        return $this->render("equipe/MembresClub/page-membre.html.twig", [
            "membreClub" => $memberClub
        ]);
    }

    /**
     * @Route("editor/membreClub/ajouter", name="ajouterMembreClub")
     */
    public function addMemberClub(Request $request, EntityManagerInterface $manager)
    {
        $memberClub = new MemberClub();

        $form = $this->createForm(MemberClubType::class, $memberClub);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($memberClub);
            $manager->flush();

            $img_nom = $memberClub->getImageName();
            if ($memberClub->getImageName() !== NULL)
            {
                $extension = strrchr($img_nom, '.');
                if($extension == ".jpeg" || $extension == ".jpg")
                {
                    $img = imagecreatefromjpeg("pictures/memberClub/" . $img_nom);
                    imagejpeg($img, "pictures/memberClub/" . $img_nom, 50);
                }
                else
                {
                    $img = imagecreatefrompng("pictures/memberClub/" . $img_nom);
                    imagepng($img, "pictures/memberClub/" . $img_nom, 5);
                }
            }

            $this->addFlash("success", "Le membre a bien été ajouté !");
            return $this->redirectToRoute("equipes", [
            ]);
        }

        return $this->render("equipe/MembresClub/addMemberClub.html.twig", [
            "formMemberClub" => $form->createView()
        ]);
    }

    /**
     * @Route("editor/membreClub/modifier/{id}", name="modifierMembreClub")
     */
    public function editMemberClub(MemberClub $memberClub, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(MemberClubType::class, $memberClub);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($memberClub);
            $manager->flush();

            $img_nom = $memberClub->getImageName();
            if ($memberClub->getImageName() !== NULL)
            {
                $extension = strrchr($img_nom, '.');
                if($extension == ".jpeg" || $extension == ".jpg")
                {
                    $img = imagecreatefromjpeg("pictures/memberClub/" . $img_nom);
                    imagejpeg($img, "pictures/memberClub/" . $img_nom, 50);
                }
                else
                {
                    $img = imagecreatefrompng("pictures/memberClub/" . $img_nom);
                    imagepng($img, "pictures/memberClub/" . $img_nom, 5);
                }
            }

            $this->addFlash("success", "Le membre a bien été modifié !");
            return $this->redirectToRoute("equipes", [
            ]);
        }

        return $this->render("equipe/MembresClub/editMemberClub.html.twig", [
            "formEditMemberClub" => $form->createView()
        ]);
    }

    /**
     * @Route("editor/membreClub/supprimer/{id}", name="supprimerMembreClub")
     */
    public function deleteMembreClub(MemberClub $memberClub, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($memberClub);
        $manager->flush();

        $this->addFlash("success", "Le membre a bien été supprimé !");
        return $this->redirectToRoute("equipes");
    }
}