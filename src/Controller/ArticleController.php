<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/articles", name="list_articles")
     *
     * j'instancie la classe ArticleRepository dans une variable
     * $articleRepository. Cela correspond à :
     * $articleRepository = new ArticleRepository() sauf que Symfony
     * s'en charge. Cela s'appelle "l'autowire".
     */
    public function listArticles(ArticleRepository $articleRepository)
    {
        // faire une requête en base de données
        // pour récupérer tous les articles de la table article.

        // les classes de repository permettent d'utiliser des requêtes
        // SQL génériques (comme récupérer tous les éléments d'une table) et
        // prêtes à l'emploi.
        $articles = $articleRepository->findAll();

        return $this->render('list_articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/search", name="search_articles")
     */
    public function searchArticles(Request $request, ArticleRepository $articleRepository)
    {
        // Je reccupére l'input 'search' de mon formulaire
        $search = $request->query->get('search');

        // je créé une requête en BDD pour recupérer tout mes articles correspondant
        // à la recherche de l'utilisateur (de mon input 'search')
        $articles = $articleRepository->searchByTerm($search);

        // Je retourne ma vue 'list_articles.html.twig' + le resultat de la recherche utilisateur
        return $this->render('list_articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/{id}", name="show_article")
     */
    public function showArticle($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        return $this->render('show_article.html.twig', [
            'article' => $article
        ]);
    }

}
