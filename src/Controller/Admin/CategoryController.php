<?php


namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class CategoryController extends AbstractController
{

    /**
     * @Route("/admin/categories", name="admin_list_categories")
     */
    public function listCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('/admin/list_categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/categories/add", name="admin_add_categories")
     */
    public function addCategory(EntityManagerInterface $entityManager, Request $request)
    {
        $category = new Category();

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            $category = $categoryForm->getData();

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash("success","Votre catégorie à bien été ajouté.");
            return $this->redirectToRoute('admin_list_categories');
        }

        return $this->render('/admin/add_categories.html.twig', [
            'addCategoriesForm' => $categoryForm->createView()
        ]);

    }

    /**
     * @Route("/admin/categories/edit/{id}", name="admin_edit_categories")
     */
    public function editArticle(Request $request, CategoryRepository $articleRepository, EntityManagerInterface $entityManager, $id)
    {

        $category = $articleRepository->find($id);

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            $category = $categoryForm->getData();

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash("success", "Votre catégorie à bien été modifié.");
            return $this->redirectToRoute('admin_list_categories');
        }

        return $this->render('/admin/edit_categories.html.twig', [
            'editCategoriesForm' => $categoryForm->createView()
        ]);

    }

    /**
     * @Route("/admin/categories/remove/{id}", name="admin_remove_categories")
     */
    public function removeArticle($id, CategoryRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $category = $articleRepository->find($id);

        if (is_null($category)) {
            throw $this->createNotFoundException('Catégorie non trouvée');
        }

        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('success', 'Votre article à bien été suprimé.');

        return $this->redirectToRoute('admin_list_categories');
    }

}