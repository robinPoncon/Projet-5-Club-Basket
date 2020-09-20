<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Diaporama;
use App\Entity\Inscription;
use App\Entity\PhotoArticle;
use App\Entity\PhotoDiaporama;
use App\Form\ArticleClubType;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Form\DiaporamaType;
use App\Form\InscriptionType;
use App\Notification\InscriptionNotification;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\DiaporamaRepository;
use App\Repository\MemberClubRepository;
use App\Repository\PhotoArticleRepository;
use App\Repository\SponsorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;
use Knp\Component\Pager\PaginatorInterface;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, PaginatorInterface $paginator, ArticleRepository $articleRepo,
                         DiaporamaRepository $diaporamaRepo)
    {
        $diaporama = $diaporamaRepo->find(2);
        $articlePrio = $articleRepo->findOneBy(["prioritaire" => 1], ["createdAt" => "DESC"]);
        $photoImportantePrios = $articlePrio->getPhotoArticles();
        $donnees = $this->getDoctrine()->getRepository(Article::class)->findBy(["prioritaire" => 0],[
            'createdAt' => 'desc',
        ]);

        $articles = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->get('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

        //$rss = simplexml_load_file('http://www.ffbb.com/rss2.xml');

        return $this->render("blog/home.html.twig", [
            "articles" => $articles,
            "articlePrio" => $articlePrio,
            "photoImportantePrios" => $photoImportantePrios,
            "diaporama" => $diaporama,
            //'rssItems' => $rss->channel->item
        ]);
    }

    /**
     * @Route("editor/diaporama/modifier/{id}", name="modifierDiaporama")
     */

    public function modifierDiaporama(Diaporama $diaporama,Request $request, EntityManagerInterface $manager)
    {
        $photoDiapos = $diaporama->getPhotoDiapos();

        $form = $this->createForm(DiaporamaType::class, $diaporama);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            foreach($photoDiapos as $key => $photoDiapo)
            {
                $photoDiapo->setDiaporama($diaporama);
                $manager->persist($photoDiapo);

                $img_nom = $photoDiapo->getImageName();
                $extension = strrchr($img_nom, '.');
                if($extension == ".jpeg" || $extension == ".jpg")
                {
                    $img = imagecreatefromjpeg("pictures/diaporama/" . $img_nom);
                    imagejpeg($img, "pictures/diaporama/" . $img_nom, 50);
                }
                else
                {
                    $img = imagecreatefrompng("pictures/diaporama/" . $img_nom);
                    imagepng($img, "pictures/diaporama/" . $img_nom, 5);
                }
            }

            $manager->persist($diaporama);
            $manager->flush();

            $this->addFlash("success", "Le diaporama a bien été modifié !");
            return $this->redirectToRoute("home");
        }

        return $this->render("blog/diaporama.html.twig", [
            "formDiapo" => $form->createView(),
            "photoDiapos" => $photoDiapos
        ]);
    }

    /**
     * @Route("editor/diaporama/supprimer/{id}", name="supprimerPhotoDiapo")
     */
    public function deletePhotoDiapo(PhotoDiaporama $photoDiapo, Request $request, EntityManagerInterface $manager)
    {
        $diaporama = $photoDiapo->getDiaporama();
        $manager->remove($photoDiapo);
        $manager->flush();

        $this->addFlash("success", "La photo a bien été supprimée !");
        return $this->redirectToRoute("modifierDiaporama", [
            "id" => $diaporama->getId()
        ]);
    }

    /**
     * @Route("tournois", name="tournois")
     */
    public function tournois(ArticleRepository $articleRepo){

        $articles = $articleRepo->findBy([], ["createdAt" => "DESC"]);
        return $this->render("blog/tournois.html.twig", [
            "articles" => $articles
        ]);
    }

    /**
     * @Route("envoiePhoto", name="envoiePhoto")
     */
    public function envoiePhoto(ArticleRepository $articleRepo){

        $articles = $articleRepo->findByCategory(5);
        return $this->render("blog/envoie-photo.html.twig", [
            "articles" => $articles
        ]);
    }

    /**
     * @Route("club-BCM/la-vie-au-club", name="club")
     */
    public function club(ArticleRepository $articleRepo, MemberClubRepository $memberClubRepo, SponsorRepository $sponsorRepo)
    {
        $sponsors = $sponsorRepo->findAll();
        $memberClubs = $memberClubRepo->findAll();
        $articles = $articleRepo->findByCategory(3);
        return $this->render("blog/club/vie-club.html.twig", [
            "articles" => $articles,
            "memberClubs" => $memberClubs,
            "sponsors" => $sponsors
        ]);
    }

    /**
     * @Route("club-BCM/inscription", name="clubInscription")
     */
    public function clubInscription(ArticleRepository $articleRepo, Request $request, InscriptionNotification $notification){

        $articles = $articleRepo->findByCategory(4);

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
     * @Route("editor/articles", name="articles")
     */
    public function showAll(ArticleRepository $articleRepo, CategoryRepository $categoryRepo)
    {
        $categorys = $categoryRepo->findAll();
        $articles = $articleRepo->findByCategory(1, 2);
        //dump($articles);
        return $this->render('security/editor/compte-articles.html.twig', [
            "articles" => $articles,
            "categorys" => $categorys
        ]);
    }

    /**
     * @Route("articles/{slug}", name="show-article")
     */
    public function showOne(Article $article, Request $request, EntityManagerInterface $manager,
                            PhotoArticleRepository $photoArticleRepo)
    {
        $user = $this->getUser();
        $commentaire = new Comment();
        $photoArticles = $photoArticleRepo->findBy(["important" => 0, "article" => $article->getId()]);
        $photoImportante = $photoArticleRepo->findOneBy(["important" => 1, "article" => $article->getId()]);

        $form = $this->createForm(CommentType::class, $commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $commentaire->setCreatedAt(new \DateTime());
            $commentaire->setArticle($article);
            $commentaire->setUser($user);
            $commentaire->setAuthor($user->getUsername());
            $manager->persist($commentaire);
            $manager->flush();

            $this->addFlash("success", "Merci ! Votre commentaire a bien été ajouté !");
            return $this->redirectToRoute("show-article", [
                "slug" => $article->getSlug()
            ]);
        }
        return $this->render("blog/article/show.html.twig", [
            'article' => $article,
            "formComment" => $form->createView(),
            "photoImportante" => $photoImportante,
            "photoArticles" => $photoArticles
        ]);
    }

    /**
     * @Route("editor/articles/data", name="ajax_article")
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
     * @Route("editor/articles/ajouter", name="ajouterArticle")
     */
    public function addPost(Request $request, EntityManagerInterface $manager)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $article->setCreatedAt(new \DateTime());

            $photoArticles = $article->getPhotoArticles();
            foreach($photoArticles as $key => $photoArticle)
            {
                $photoArticle->setArticle($article);
                if($photoArticle->getImportant() == NULL)
                {
                    $photoArticle->setImportant(0);
                }
                $photoArticles->set($key,$photoArticle);
                $manager->persist($photoArticle);

                $img_nom = $photoArticle->getImageName();
                $extension = strrchr($img_nom, '.');
                if($extension == ".jpeg" || $extension == ".jpg")
                {
                    $img = imagecreatefromjpeg("pictures/article/" . $img_nom);
                    imagejpeg($img, "pictures/article/" . $img_nom, 50);
                }
                else
                {
                    $img = imagecreatefrompng("pictures/article/" . $img_nom);
                    imagepng($img, "pictures/article/" . $img_nom, 5);
                }
            }

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
     * @Route("editor/articles/modifier/{slug}", name="modifierArticle")
     */
    public function editPost(Article $article, Request $request, EntityManagerInterface $manager,
                             ArticleRepository $articleRepo)
    {
        $allPhotoArticles = $article->getPhotoArticles();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($article->getPrioritaire())
            {
                $articles = $articleRepo->findAll();
                foreach($articles as $autreArticle)
                {
                    $autreArticle->setPrioritaire(0);
                    $article->setPrioritaire(1);
                    $manager->persist($autreArticle);
                }
            }

            $photoArticles = $article->getPhotoArticles();
            foreach($photoArticles as $key => $photoArticle)
            {
                $photoArticle->setArticle($article);
                if($photoArticle->getImportant() == NULL)
                {
                    $photoArticle->setImportant(0);
                }
                $photoArticles->set($key,$photoArticle);
                $manager->persist($photoArticle);

                $img_nom = $photoArticle->getImageName();
                $extension = strrchr($img_nom, '.');
                if($extension == ".jpeg" || $extension == ".jpg")
                {
                    $img = imagecreatefromjpeg("pictures/article/" . $img_nom);
                    imagejpeg($img, "pictures/article/" . $img_nom, 50);
                }
                else
                {
                    $img = imagecreatefrompng("pictures/article/" . $img_nom);
                    imagepng($img, "pictures/article/" . $img_nom, 5);
                }
            }

            $manager->persist($article);
            $manager->flush();

            $this->addFlash("success", "L'article a bien été modifié !");
            return $this->redirectToRoute("show-article", [
                "slug" => $article->getSlug()
            ]);
        }

        return $this->render("blog/article/edit.html.twig", [
            "formArticle" => $form->createView(),
            "photoArticles" => $allPhotoArticles
        ]);
    }

    /**
     * @Route("editor/articles/mettreEnAvant/photo/{id}", name="mettreEnAvantPhotoArticle")
     */
    public function mettreEnAvantPhotoArticle(PhotoArticle $photoArticle, Request $request, EntityManagerInterface $manager)
    {
        $article = $photoArticle->getArticle();
        $photoArticles = $article->getPhotoArticles();
        foreach($photoArticles as $photoPasImportante)
        {
            $photoPasImportante->setImportant(0);
            $manager->persist($photoPasImportante);
        }
        $photoArticle->setImportant(1);
        $manager->persist($photoArticle);
        $manager->flush();

        $this->addFlash("success", "La photo a bien été mise en avant !");
        return $this->redirectToRoute("modifierArticle", [
            "slug" => $article->getSlug()
        ]);
    }

    /**
     * @Route("editor/articles/supprimer/photo/{id}", name="supprimerPhotoArticle")
     */
    public function deletePhotoArticle(PhotoArticle $photoArticle, Request $request, EntityManagerInterface $manager)
    {
        $article = $photoArticle->getArticle();
        $manager->remove($photoArticle);
        $manager->flush();

        $this->addFlash("success", "La photo a bien été supprimée !");
        return $this->redirectToRoute("modifierArticle", [
            "slug" => $article->getSlug()
        ]);
    }

    /**
     * @Route("editor/articles/club/modifier/{slug}", name="modifierArticleClub")
     */
    public function editPostClub(Article $article, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ArticleClubType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($article);
            $manager->flush();

            $this->addFlash("success", "L'article a bien été modifié !");

            //dump($article->getCategory());
            $categorys = $article->getCategory();
            foreach($categorys as $key => $category) {
                if($category->getTitle() === "Club")
                {
                    return $this->redirectToRoute("club");
                }
                else if($category->getTitle() === "Inscription")
                {
                    return $this->redirectToRoute("clubInscription");
                }
                else if($category->getTitle() === "EnvoiePhoto")
                {
                    return $this->redirectToRoute("envoiePhoto");
                }
            }
        }

        return $this->render("blog/club/editClub.html.twig", [
            "formArticle" => $form->createView(),
            "article" => $article
        ]);
    }

    /**
     * @Route("editor/articles/delete/{id}", name="supprimerArticle")
     */
    public function deletePost(Article $article, EntityManagerInterface $manager)
    {
        $manager->remove($article);
        $manager->flush();

        $this->addFlash("success", "L'article a bien été supprimé !");
        return $this->redirectToRoute("articles");
    }



    /**
     * @Route("editor/articles/commentaires/modifier/{id}", name="modifierComment")
     */
    public function editComment(Comment $comment, Request $request, EntityManagerInterface $manager)
    {
        $article = $comment->getArticle();
        //dump($article);
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
     * @Route("editor/articles/commentaires/supprimer/{id}", name="supprimerComment")
     */
    public function deleteComment(Comment $comment, EntityManagerInterface $manager)
    {
        $article = $comment->getArticle();
        //dump($article);
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash("success", "Le commentaire a bien été supprimé !");
        return $this->redirectToRoute("show-article", [
            "slug" => $article->getSlug()
        ]);
    }

}
