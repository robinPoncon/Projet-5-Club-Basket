<?php

namespace App\Controller;

use App\Entity\Equipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe/{name}", name="equipe")
     * @param Equipe $equipe
     * @return Response
     */
    public function index(Equipe $equipe)
    {
        return $this->render("equipe/team.html.twig", [
            'equipe' => $equipe
        ]);
    }
}
