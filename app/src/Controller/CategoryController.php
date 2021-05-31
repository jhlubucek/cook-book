<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends BaseController
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/category", name="category_list")
     */
    public function index(): Response
    {
        if (!$this->isAdmin()){
            $this->addFlash('danger', 'You are not authorised here.');
            return  $this->redirectToRoute('main_page');
        }

        $categories = $this->categoryRepository->findAll();


        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/new/category/", name="category_new")
     */
    public function new(Request $request): Response
    {
        if (!$this->isAdmin()){
            $this->addFlash('danger', 'You are not authorised here.');
            return  $this->redirectToRoute('main_page');
        }

        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $name = $form->get('name')->getData();
            $category->setName($name);
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_list');
        }

        return $this->render('category/new.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/edit/category/{id}", name="category_edit")
     */
    public function edit(Request $request, $id): Response
    {
        if (!$this->isAdmin()){
            $this->addFlash('danger', 'You are not authorised here.');
            return  $this->redirectToRoute('main_page');
        }

        $category = $this->categoryRepository->findOneById($id);
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $name = $form->get('name')->getData();
            $category->setName($name);
            $entityManager->flush();

            return $this->redirectToRoute('category_list');
        }

        return $this->render('category/new.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/delete/category/{id}", name="category_delete")
     */
    public function delete(Request $request, $id): Response
    {
        if (!$this->isAdmin()){
            $this->addFlash('danger', 'You are not authorised here.');
            return  $this->redirectToRoute('main_page');
        }

        $category = $this->categoryRepository->findOneById($id);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('category_list');

    }

//    /**
//     * @Route("/category/edit", name="category")
//     * @param Request $request
//     * @return Response
//     */
//    public function edit2(Request $request): Response
//    {
//
//        $categories = $this->categoryRepository->findAll();
//        $forms = [];
//        $views = [];
//        $entityManager = $this->getDoctrine()->getManager();
//        foreach ($categories as $category){
////            $form = $this->createForm(CategoryFormType::class, $category, ["block_prefix" => "pica"]);
////            $form->handleRequest($request);
//
//            $form = $this->createFormBuilder($category)
//                ->add('name')
//                ->add('save', SubmitType::class)
//                ->getForm();
//
//            $form->handleRequest($request);
//            dump($form);
//            dump($form->isSubmitted());
//            if ($form->isSubmitted()) {
//                $name = $form->get('name')->getData();
//                $category->setName($name);
//
//                dump($category);
//                $entityManager->persist($category);
//                $entityManager->flush();
//            }
//            $views[] = $form->createView();
//
//        }
//
//
//        return $this->render('category/edit.html.twig', [
//            'controller_name' => 'CategoryController',
//            'forms' => $views,
//        ]);
//    }
}
