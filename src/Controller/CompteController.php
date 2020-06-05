<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte/home", name="homeCompte")
     */
    public function index()
    {
        return $this->render('security/compte/compte-home.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }
}
