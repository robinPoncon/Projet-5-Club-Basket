<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Inscription;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Form\InscriptionType;
use App\Notification\InscriptionNotification;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(ArticleRepository $articleRepo)
    {
        $articles = $articleRepo->findAll();
        return $this->render("blog/home.html.twig", [
            "articles" => $articles
        ]);
    }

    /**
     * @Route("tournois", name="tournois")
     */
    public function tournois(ArticleRepository $articleRepo){
        $articles = $articleRepo->findAll();
        return $this->render("blog/tournois.html.twig", [
            "articles" => $articles
        ]);
    }

    /**
     * @Route("club/la-vie-au-club", name="club")
     */
    public function club(ArticleRepository $articleRepo){
        $articles = $articleRepo->findAll();
        return $this->render("blog/club/vie-club.html.twig", [
            "articles" => $articles
        ]);
    }

    /**
     * @Route("club/inscription", name="clubInscription")
     */
    public function clubInscription(ArticleRepository $articleRepo, Request $request, InscriptionNotification $notification){

        $articles = $articleRepo->findAll();

        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $notification->notify($inscription);
            $this->addFlash("success", "Merci ! Votre email a bien été envoyé !");
            return $this->redirectToRoute("home");
        }

        return $this->render('blog/club/inscription-club.html.twig', [
            "formInscriptionBCM" => $form->createView(),
            "articles" => $articles
        ]);
    }

    /**
     * @Route("admin/articles", name="articles")
     */
    public function showAll(ArticleRepository $articleRepo, CategoryRepository $categoryRepo)
    {
        $categorys = $categoryRepo->findAll();
        $articles = $articleRepo->findAll();
        return $this->render('security/admin/compte-articles.html.twig', [
            "articles" => $articles,
            "categorys" => $categorys
        ]);
    }

    /**
     * @Route("articles/{slug}", name="show-article")
     */
    public function showOne(Article $article, Request $request, EntityManagerInterface $manager)
    {
        $commentaire = new Comment();

        $form = $this->createForm(CommentType::class, $commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $commentaire->setCreatedAt(new \DateTime());
            $commentaire->setArticle($article);
            $manager->persist($commentaire);
            $manager->flush();

            $this->addFlash("success", "Merci ! Votre commentaire a bien été ajouté !");
            return $this->redirectToRoute("show-article", [
                "slug" => $article->getSlug()
            ]);
        }
        return $this->render("blog/article/show.html.twig", [
            'article' => $article,
            "formComment" => $form->createView()
        ]);
    }

    /**
     * @Route("admin/articles/data", name="ajax_article")
     */
    public function ajaxArticle(Request $request, CategoryRepository $categoryRepo)
    {
        if($request->isXmlHttpRequest()) {
            // On récupère l'id de la requête
            $idCategory = $request->request->get('id');

            $categoryObjet = $categoryRepo->find($idCategory);
            //dump($categoryObjet);

            // On récupère l'équipe correspondant à l'id
            $articles = $categoryObjet->getArticles();
            //dump($articles);

            // On spécifie qu'on utilise un encodeur en json
            $encoders = [new JsonEncoder()];

            // On instancie le "normaliseur" pour convertir la collection en tableau
            $normalizers = [new ObjectNormalizer()];

            // On instancie le convertisseur
            $serializer = new Serializer($normalizers, $encoders);

            // On convertit en json
            $jsonContent = $serializer->serialize($articles, "json", [
                "circular_reference_handler" => function ($object) {
                    return $object->getId();
                }
            ]);

            //dump($jsonContent);

            // On instancie la réponse
            $response = new Response($jsonContent);

            // On ajoute l'entête HTTP
            $response->headers->set("Content-Type", "application/json");

            //dump($response);
            // On envoie la réponse
            return $response;
        }
        else {
            return new Response("erreur");
        }
    }

    /**
     * @Route("admin/articles/ajouter", name="ajouterArticle")
     */
    public function addPost(Request $request, EntityManagerInterface $manager)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $article->setCreatedAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();

            $this->addFlash("success", "L'article a bien été ajouté !");
            return $this->redirectToRoute("show-article", [
                "slug" => $article->getSlug()
            ]);
        }

        return $this->render("blog/article/add.html.twig", [
            "formArticle" => $form->createView()
        ]);
    }

    /**
     * @Route("admin/articles/modifier/{slug}", name="modifierArticle")
     */
    public function editPost(Article $article, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($article);
            $manager->flush();

            $this->addFlash("success", "L'article a bien été modifié !");
            return $this->redirectToRoute("show-article", [
                "slug" => $article->getSlug()
            ]);
        }

        return $this->render("blog/article/edit.html.twig", [
            "formArticle" => $form->createView()
        ]);
    }

    /**
     * @Route("admin/articles/delete/{id}", name="supprimerArticle")
     */
    public function deletePost(Article $article, EntityManagerInterface $manager)
    {
        $manager->remove($article);
        $manager->flush();

        $this->addFlash("success", "L'article a bien été supprimé !");
        return $this->redirectToRoute("articles");
    }

    /**
     * @Route("articles/commentaires/modifier/{id}", name="modifierComment")
     */
    public function editComment(Comment $comment, Request $request, EntityManagerInterface $manager)
    {
        $article = $comment->getArticle();
        dump($article);
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash("success", "Le commentaire a bien été modifié !");
            return $this->redirectToRoute("show-article", [
                "slug" => $article->getSlug()
            ]);
        }

        return $this->render("blog/comment/editComment.html.twig", [
            "formComment" => $form->createView()
        ]);
    }

    /**
     * @Route("articles/commentaires/supprimer/{id}", name="supprimerComment")
     */
    public function deleteComment(Comment $comment, EntityManagerInterface $manager)
    {
        $article = $comment->getArticle();
        dump($article);
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash("success", "Le commentaire a bien été supprimé !");
        return $this->redirectToRoute("show-article", [
            "slug" => $article->getSlug()
        ]);
    }

}