<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRoleType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/utilisateurs", name="users")
     */
    public function index(UserRepository $userRepo)
    {
        $users = $userRepo->findAll();
        return $this->render('security/admin/compte-users.html.twig', [
            "users" => $users
        ]);
    }

    /**
     * @Route("admin/utilisateurs/modifier/{slug}", name="modifierUtilisateur")
     */
    public function modifRoleUser(User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserRoleType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "L'utilisateur a bien été modifié !");
            return $this->redirectToRoute("users", [

            ]);
        }

        return $this->render("security/admin/edit-user.html.twig", [
            "formUser" => $form->createView()
        ]);
    }
}
