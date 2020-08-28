<?php

namespace App\Controller;

use App\Entity\ChangePassword;
use App\Entity\PhotoUser;
use App\Entity\User;
use App\Form\PhotoUserType;
use App\Form\ResetPasswordType;
use App\Form\UserInfosFormType;
use App\Repository\PhotoUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CompteController extends AbstractController
{
    /**
     * @Route("profil", name="homeCompte")
     */
    public function espacePerso()
    {
        $user = $this->getUser();
        $photo = $user->getPhotoUser();
        //dump($photo);
        return $this->render('security/profil/compte-home.html.twig', [
            "user" => $user,
            "photoUser" => $photo
        ]);
    }

    /**
     * @Route("profil/modifier/infos/{slug}", name="modifierInfosProfil")
     */
    public function modifierInfosProfil(User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserInfosFormType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "Vos informations ont bien été modifiées !");
            return $this->redirectToRoute("homeCompte", [

            ]);
        }

        return $this->render("security/profil/editInfos-user.html.twig", [
            "formInfosUser" => $form->createView()
        ]);
    }

    /**
     * @Route("profil/ajouter/photo/{slug}", name="ajouterPhotoProfil")
     */
    public function ajouterPhotoProfil(User $user, Request $request, EntityManagerInterface $manager)
    {
        $newPhotoProfil = new PhotoUser();

        $form = $this->createForm(PhotoUserType::class, $newPhotoProfil);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
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


            $this->addFlash("success", "Votre photo de profil a bien été ajoutée !");
            return $this->redirectToRoute("homeCompte", [

            ]);
        }

        return $this->render("security/profil/editPhoto-user.html.twig", [
            "formPhotoUser" => $form->createView()
        ]);
    }

    /**
     * @Route("profil/modifier/photo/{slug}", name="modifierPhotoProfil")
     */
    public function modifierPhotoProfil(User $user, Request $request, EntityManagerInterface $manager)
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

            $this->addFlash("success", "Votre photo de profil a bien été mise à jour !");
            return $this->redirectToRoute("homeCompte", [

            ]);
        }

        return $this->render("security/profil/editPhoto-user.html.twig", [
            "formPhotoUser" => $form->createView()
        ]);
    }

    /**
     * @Route("profil/supprimer/photo/{id}", name="supprimerPhotoProfil")
     */
    public function deletePhotoProfil(PhotoUser $photoUser, EntityManagerInterface $manager)
    {
        $manager->remove($photoUser);
        $manager->flush();

        $this->addFlash("success", "Votre photo de profil a bien été supprimée !");
        return $this->redirectToRoute("homeCompte");
    }

    /**
     * @Route("profil/modifier/mot-de-passe/{slug}", name="modifMotDePasse")
     */
    public function modifMotDePasse(User $user, Request $request, EntityManagerInterface $manager,
                                    UserPasswordEncoderInterface $encoder)
    {
        $changePassword = new ChangePassword();

        $form = $this->createForm(ResetPasswordType::class, $changePassword);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $newPassword = $changePassword->getNewPassword();
            $newEncodedPassword = $encoder->encodePassword($user, $newPassword);

            $user->setPassword($newEncodedPassword);

            $manager->flush();

            $this->addFlash("success", "Votre mot de passe a bien été modifié !");
            return $this->redirectToRoute("homeCompte");
        }

        return $this->render("security/profil/editMDP-user.html.twig", [
            "formMDPUser" => $form->createView()
        ]);
    }

    /**
     * @Route("profil/supprimer/{id}", name="supprimerCompte")
     */
    public function deleteUser(User $user, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->container->get('security.token_storage')->setToken(null);
        $this->addFlash("success", "L'utilisateur a bien été supprimé !");
        return $this->redirectToRoute("home");
    }
}
