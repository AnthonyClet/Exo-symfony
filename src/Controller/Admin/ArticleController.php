<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    //Je défini ma route
    /**
     * @Route("/admin/articles/add", name="admin_add_article")
     */

    // Je créer ma fonction qui va me permetre d'ajouter un article a ma BDD et je lui fais hériter
    // de la class EntityManagerInterface.
    public function addArticle(EntityManagerInterface $entityManager)
    {
        // Je créer mon article
        $article = new Article();

        $articleForm = $this->createForm(ArticleType::class, $article);

        return $this->render('/admin/add_articles.html.twig', [
            'articleFormView' => $articleForm->createView()
        ]);

//        // Je lui attribue toutes les valeurs liées aux colonnes de mes entités.
//        $article->setTitle('Je suis nouveau');
//        $article->setContent('On m\'a ajouté grace au nouveau bouton !');
//        $article->setCreatedAt(new \DateTime('NOW'));
//
//        // Je dis à doctrine que je viens de créer mon article.
//        $entityManager->persist($article);
//
//        // Je demande à doctrine d'envoyer tout les elements en BDD.
//        $entityManager->flush();
//
//        //Je retourne ma vue affin d'afficher un message de confirmation.
//        $this->addFlash("success","l'article à bien été enregisté.");
//        return $this->redirectToRoute('admin_list_articles');

        /*
        $this->addFlash("success","l article a bien ete enregister");
        */
    }


    /**
     * @Route("/admin/articles/edit/{id}", name="admin_edit_article")
     */
    // Je créer ma méthode.
    public function editArticle(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, $id)
    {
        // Je fais ma requete pour aller chercher mon article correspondant à ma withecard
        $article = $articleRepository->find($id);

        if(is_null($article)) {
            throw $this->createNotFoundException('article non trouvé');
        } else {

            // Je modifie les infos de mon article a ma convenance (en l'occurence le titre)
            $article->setTitle('J\'ai été modifié');

            // j'enregistre la modification dans ma BDD grace a flush().
            $entityManager->flush();

            // Je retourne un message comme quoi mon article a bien été modifié.
            $this->addFlash("success","l'article à bien été modifié.");
            return $this->redirectToRoute('admin_list_articles');
        }

    }

    /**
     * @Route("/admin/articles/remove/{id}", name="admin_remove_article")
     */
    public function removeArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

        if (is_null($article)) {
            throw $this->createNotFoundException('article non trouvé');
        }

        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('success', 'Votre article à bien été suprimé.');

        return $this->redirectToRoute('admin_list_articles');
    }

    /**
     * @Route("/admin/articles", name="admin_list_articles")
     */
    public function showArticles(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render('/admin/list_articles.html.twig', [
            'articles' => $articles
        ]);
    }


}