<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    /**
     * @Route("profil/home", name="homeCompte")
     */
    public function index()
    {
        return $this->render('security/admin/compte-home.html.twig', [

        ]);
    }
}
