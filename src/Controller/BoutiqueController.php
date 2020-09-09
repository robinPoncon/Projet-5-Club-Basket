<?php

namespace App\Controller;

use App\Entity\Color;
use App\Entity\Produit;
use App\Entity\Taille;
use App\Form\ColorType;
use App\Form\ProduitType;
use App\Form\TailleType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    /**
     * @Route("boutique/produits", name="allProduits")
     */
    public function allProduits(ProduitRepository $produitRepo)
    {
        $produits = $produitRepo->findAll();

        return $this->render("boutique/allProduits.html.twig", [
            "produits" => $produits
        ]);
    }

    /**
     * @Route("editor/boutique/produits", name="produits")
     */
    public function gestionProduits(ProduitRepository $produitRepo)
    {
        $produits = $produitRepo->findAll();

        return $this->render("security/editor/compte-boutique.html.twig", [
            "produits" => $produits
        ]);
    }

    /**
     * @Route("boutique/produit/{slug}", name="ficheProduit")
     */
    public function show(Produit $produit)
    {
        return $this->render("boutique/page-produit.html.twig", [
            "produit" => $produit
        ]);
    }

    /**
     * @Route("editor/boutique/produit/ajouter", name="addProduit")
     */
    public function addProduit(Request $request, EntityManagerInterface $manager)
    {
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $photoProduits = $produit->getPhotoProduits();
            foreach($photoProduits as $key => $photoProduit)
            {
                $photoProduit->setProduit($produit);
                if($photoProduit->getImportant() == NULL)
                {
                    $photoProduit->setImportant(0);
                }
                $photoProduits->set($key,$photoProduit);
                $manager->persist($photoProduit);

                $img_nom = $photoProduit->getImageName();
                $extension = strrchr($img_nom, '.');
                if($extension == ".jpeg" || $extension == ".jpg")
                {
                    $img = imagecreatefromjpeg("pictures/produit/" . $img_nom);
                    imagejpeg($img, "pictures/produit/" . $img_nom, 50);
                }
                else
                {
                    $img = imagecreatefrompng("pictures/produit/" . $img_nom);
                    imagepng($img, "pictures/produit/" . $img_nom, 5);
                }
            }

            $manager->persist($produit);
            $manager->flush();

            $this->addFlash("success", "Le produit a bien été ajouté !");
            return $this->redirectToRoute("produits", [
            ]);
        }

        return $this->render("boutique/addProduit.html.twig", [
            "formProduit" => $form->createView()
        ]);
    }

    /**
     * @Route("editor/boutique/couleur/ajouter", name="addColor")
     */
    public function addColor(Request $request, EntityManagerInterface $manager)
    {
        $color = new Color();

        $form = $this->createForm(ColorType::class, $color);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($color);
            $manager->flush();

            $this->addFlash("success", "La couleur a bien été ajoutée !");
            return $this->redirectToRoute("produits", [
            ]);
        }

        return $this->render("boutique/addColor.html.twig", [
            "formColor" => $form->createView()
        ]);
    }

    /**
     * @Route("editor/boutique/taille/ajouter", name="addTaille")
     */
    public function addTaille(Request $request, EntityManagerInterface $manager)
    {
        $taille = new Taille();

        $form = $this->createForm(TailleType::class, $taille);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($taille);
            $manager->flush();

            $this->addFlash("success", "La taille a bien été ajoutée !");
            return $this->redirectToRoute("produits", [
            ]);
        }

        return $this->render("boutique/addTaille.html.twig", [
            "formTaille" => $form->createView()
        ]);
    }

}