<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
    public function showAll(ArticleRepository $articleRepo)
    {
        $articles = $articleRepo->findAll();
        return $this->render('security/admin/compte-articles.html.twig', [
            "articles" => $articles
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
