<?php

namespace App\Controller;

use App\Entity\PhotoUser;
use App\Entity\User;
use App\Form\PhotoUserType;
use App\Form\UserInfosFormType;
use App\Form\UserRoleType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("admin/utilisateurs", name="users")
     */
    public function index(UserRepository $userRepo)
    {
        $users = $userRepo->findAll();
        return $this->render('security/admin/compte-users.html.twig', [
            "users" => $users
        ]);
    }

    /**
     * @Route("admin/utilisateurs/{slug}", name="pageUtilisateur")
     */
    public function pageUtilisateur(User $user)
    {
        $photoUser = $user->getPhotoUser();
        return $this->render("security/admin/page-user.html.twig", [
            "user" => $user,
            "photoUser" => $photoUser
        ]);
    }

    /**
     * @Route("admin/utilisateurs/ajouter/photo/{slug}", name="ajouterPhotoProfilUser")
     */
    public function ajouterPhotoProfilUser(User $user, Request $request, EntityManagerInterface $manager)
    {
        $newPhotoProfil = new PhotoUser();

        $form = $this->createForm(PhotoUserType::class, $newPhotoProfil);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            dump($newPhotoProfil);
            $user->setPhotoUser($newPhotoProfil);
            $manager->persist($newPhotoProfil);
            $manager->flush();

            $img_nom = $newPhotoProfil->getImageName();
            $extension = strrchr($img_nom, '.');
            if($extension == '.jpeg' || $extension == '.jpg')
            {
                $img = imagecreatefromjpeg('pictures/avatar/' . $img_nom);
                imagejpeg($img, 'pictures/avatar/' . $img_nom, 50);
            }
            else
            {
                $img = imagecreatefrompng('pictures/avatar/' . $img_nom);
                imagepng($img, 'pictures/avatar/' . $img_nom, 5);
            }


            $this->addFlash("success", "La photo de profil de l'utilisateur a bien été mise à jour !");
            return $this->redirectToRoute("pageUtilisateur", [
                "slug" => $user->getSlug()
            ]);
        }

        return $this->render("security/profil/editPhoto-user.html.twig", [
            "formPhotoUser" => $form->createView()
        ]);
    }

    /**
     * @Route("admin/utilisateurs/modifier/photo/{slug}", name="modifierPhotoProfilUser")
     */
    public function modifierPhotoProfilUser(User $user, Request $request, EntityManagerInterface $manager)
    {
        $photoProfil = $user->getPhotoUser();

        $form = $this->createForm(PhotoUserType::class, $photoProfil);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //dump($photoProfil);
            $manager->persist($photoProfil);
            $manager->flush();

            $img_nom = $photoProfil->getImageName();
            $extension = strrchr($img_nom, '.');
            if($extension == ".jpeg" || $extension == ".jpg")
            {
                $img = imagecreatefromjpeg("pictures/avatar/" . $img_nom);
                imagejpeg($img, "pictures/avatar/" . $img_nom, 50);
            }
            else
            {
                $img = imagecreatefrompng("pictures/avatar/" . $img_nom);
                imagepng($img, "pictures/avatar/" . $img_nom, 5);
            }

            $this->addFlash("success", "La photo de profil de l'utilisateur a bien été mise à jour !");
            return $this->redirectToRoute("pageUtilisateur", [
                "slug" => $user->getSlug()
            ]);
        }

        return $this->render("security/profil/editPhoto-user.html.twig", [
            "formPhotoUser" => $form->createView()
        ]);
    }

    /**
     * @Route("admin/utilisateurs/supprimer/photo/{id}", name="supprimerPhotoProfilUser")
     */
    public function deletePhotoProfil(PhotoUser $photoUser, EntityManagerInterface $manager)
    {
        $user = $photoUser->getUser();
        $manager->remove($photoUser);
        $manager->flush();

        $this->addFlash("success", "La photo de profil de l'utilisateur a bien été supprimée !");
        return $this->redirectToRoute("pageUtilisateur", [
            "slug" => $user->getSlug()
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

        return $this->render("security/admin/editRoles-user.html.twig", [
            "formUser" => $form->createView()
        ]);
    }

    /**
     * @Route("admin/utilisateurs/modifier/infos/{slug}", name="modifierInfosUtilisateur")
     */
    public function modifInfosUser(User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserInfosFormType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "L'utilisateur a bien été modifié !");
            return $this->redirectToRoute("pageUtilisateur", [
                "slug" => $user->getSlug()
            ]);
        }

        return $this->render("security/admin/editInfos-user.html.twig", [
            "formInfoUser" => $form->createView()
        ]);
    }



    /**
     * @Route("admin/utilisateurs/supprimer/{id}", name="supprimerUtilisateur")
     */
    public function deleteUser(User $user, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash("success", "L'utilisateur a bien été supprimé !");
        return $this->redirectToRoute("users");
    }
}
