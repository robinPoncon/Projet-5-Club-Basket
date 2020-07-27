<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\GetEmailForgotPasswordType;
use App\Form\RegistrationType;
use App\Form\UserInfosFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "Votre compte a bien été créé !");
            return $this->redirectToRoute("security_login");
        }

        return $this->render("security/registration.html.twig", [
            "formRegistration" => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/mot-de-passe-oublie", name="forgot_pass")
     */
    public function forgotPass(Request $request, UserRepository $userRepo, \Swift_Mailer $mailer,
                               TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $manager)
    {
        // On initialise le formulaire
        $form = $this->createForm(GetEmailForgotPasswordType::class);

        // On traite le formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données
            $donnees = $form->getData();

            //dump($donnees);

            // On cherche un utilisateur ayant cet e-mail
            $user = $userRepo->findOneBy(["email" => $donnees]);

            //dump($user);

            // Si l'utilisateur n'existe pas
            if ($user === null) {
                // On envoie une alerte disant que l'adresse e-mail est inconnue
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');

                // On retourne sur la page de connexion
                return $this->redirectToRoute('security_login');
            }

            // On génère un token
            $token = $tokenGenerator->generateToken();

            // On essaie d'écrire le token en base de données
            try{
                $user->setResetToken($token);
                $manager->persist($user);
                $manager->flush();
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('security_login');
            }

            // On génère l'URL de réinitialisation de mot de passe
            $url = $this->generateUrl('app_reset_password', array('token' => $token),
                UrlGeneratorInterface::ABSOLUTE_URL);

            // On génère l'e-mail
            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('basket.meximieux.contact@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site 
                           Basket Club Meximieux. Veuillez cliquer sur le lien suivant : " . $url,
                    'text/html'
                )
            ;

            // On envoie l'e-mail
            $mailer->send($message);

            // On crée le message flash de confirmation
            $this->addFlash('success', 'Email de réinitialisation du mot de passe envoyé !');

            // On redirige vers la page de login
            return $this->redirectToRoute('security_login');
        }

        // On envoie le formulaire à la vue
        return $this->render('security/forgotten_password.html.twig', [
            'emailForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/reinitialisation_mot-de-passe/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $encoder,
                                    EntityManagerInterface $manager)
    {
        // On cherche un utilisateur avec le token donné
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche une erreur
            $this->addFlash('danger', 'Temps écoulée, veuillez réeffectuer votre demande !');
            return $this->redirectToRoute('security_login');
        }

        $form = $this->createForm(ForgotPasswordType::class, $user);

        // On traite le formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid())
        {
            //On supprime le token
            $user->setResetToken(null);

            // On chiffre
            $encodePassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodePassword);

            // On stocke
            $manager->persist($user);
            $manager->flush();

            // On crée le message flash
            $this->addFlash('success', 'Votre mot de passe a bien été mis à jour !');

            // On redirige vers la page de connexion
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/reset_password.html.twig', [
            "formResetPassword" => $form->createView()
        ]);

    }
}
