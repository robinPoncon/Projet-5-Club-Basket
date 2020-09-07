<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
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
     * @Route("boutique/produit/{slug}", name="pageProduit")
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
                "slug" => $produit->getSlug()
            ]);
        }

        return $this->render("boutique/addProduit.html.twig", [
            "formProduit" => $form->createView()
        ]);
    }

}