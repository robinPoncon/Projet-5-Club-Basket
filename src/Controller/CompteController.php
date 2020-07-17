<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\User;
use App\Form\PhotoUserType;
use App\Form\UserInfosFormType;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    /**
     * @Route("profil/home", name="homeCompte")
     */
    public function espacePerso(PhotoRepository $photoRepo)
    {
        $user = $this->getUser();
        $photo = $photoRepo->findOneBy(["user" => $user]);
        dump($photo);
        return $this->render('security/profil/compte-home.html.twig', [
            "user" => $user,
            "photo" => $photo
        ]);
    }

    /**
     * @Route("profil/home/modifier/infos/{slug}", name="modifierInfosProfil")
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
     * @Route("profil/home/modifier/photo/{slug}", name="modifierPhotoProfil")
     */
    public function modifierPhotoProfil(User $user, Request $request, EntityManagerInterface $manager)
    {
        $photoProfil = new Photo();

        $form = $this->createForm(PhotoUserType::class, $photoProfil);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $photoProfil->setUser($user);
            $manager->persist($photoProfil);
            $manager->flush();

            $this->addFlash("success", "Votre photo de profil a bien été mise à jour !");
            return $this->redirectToRoute("homeCompte", [

            ]);
        }

        return $this->render("security/profil/editPhoto-user.html.twig", [
            "formPhotoUser" => $form->createView()
        ]);
    }
}
