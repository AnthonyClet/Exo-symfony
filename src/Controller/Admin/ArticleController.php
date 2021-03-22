<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    //Je défini ma route
    /**
     * @Route("/admin/article/insert", name="add_article")
     */

    // Je créer ma fonction qui va me permetre d'ajouter un article a ma BDD et je lui fais hériter
    // de la class EntityManagerInterface.
    public function addArticle(EntityManagerInterface $entityManager)
    {
        // Je créer mon article
        $article = new Article();
        // Je lui attribue toutes les valeurs liées aux colonnes de mes entités.
        $article->setTitle('Im new');
        $article->setContent('On m\'a envoyé ici j\'ai pas compris');
        $article->setCreatedAt(new \DateTime('NOW'));

        // Je dis à doctrine que je viens de créer mon article.
        $entityManager->persist($article);

        // Je demande à doctrine d'envoyer tout les elements en BDD.
        $entityManager->flush();

        //Je retourne ma vue affin d'afficher un message de confirmation.
        return $this->render('add_articles.html.twig');

        /*
        $this->addFlash("success","l article a bien ete enregister");
        return $this;
        */
    }

}