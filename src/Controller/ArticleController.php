<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
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

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render("home/home.html.twig", [
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
     * @Route("article/{slug}", name="show-article")
     */
    public function showOne(Article $article)
    {
        return $this->render("article/show.html.twig", [
            'article' => $article,
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

            dump($response);
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

            return $this->redirectToRoute("show-article", [
                "slug" => $article->getSlug()
            ]);
        }

        return $this->render("article/add.html.twig", [
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

            return $this->redirectToRoute("show-article", [
                "slug" => $article->getSlug()
            ]);
        }

        return $this->render("article/edit.html.twig", [
            "formArticle" => $form->createView()
        ]);
    }

    /**
     * @Route("admin/articles/delete/{id}", name="supprimerArticle")
     */
    public function deletePost(Article $article, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute("articles");
    }

}
