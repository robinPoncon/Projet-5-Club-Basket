<?php

namespace App\Controller;

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
     * @Route("boutique/produit/{slug}", name="")
     */
    public function show($produit)
    {

    }

}