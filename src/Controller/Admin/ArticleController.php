<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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


    /**
     * @Route("/admin/article/update/{id}", name="update_article")
     */
    // Je créer ma méthode.
    public function updateArticle(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, $id)
    {
        // Je fais ma requete pour aller chercher mon article correspondant à ma withecard
        $article = $articleRepository->find(['id'=>$id]);

        // Je modifie les infos de mon article a ma convenance (en l'occurence le titre)
        $article->setTitle('J\'ai été modifié');

        // j'enregistre la modification dans ma BDD grace a flush().
        $entityManager->flush();

        // Je retourne un message comme quoi mon article a bien été modifié.
        return new Response('Votre article a bien été modifié.');

    }


}