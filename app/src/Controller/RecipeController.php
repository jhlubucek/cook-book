<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\ImageTemporary;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\RecipeHasCategory;
use App\Form\IngredientsFormType;
use App\Form\RecipeFormType;
use App\Repository\CategoryRepository;
use App\Repository\IngredientRepository;
use App\Repository\RecipeHasCategoryRepository;
use App\Repository\RecipeRepository;
use App\Service\CategoryManager;
use App\Service\IngredientsManager;
use App\Service\MessageGenerator;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class RecipeController extends BaseController
{
    private $session;
    private $categoryRepository;
    private $ingredientsManager;
    private $categoryManager;
    private $recipeRepository;
    private $recipeHasCategoryRepository;
    private $ingredientRepository;

    public function __construct(
        SessionInterface $session,
        RecipeRepository $recipeRepository,
        CategoryRepository $categoryRepository,
        IngredientsManager $ingredientsManager,
        CategoryManager $categoryManager,
        RecipeHasCategoryRepository $recipeHasCategoryRepository,
        IngredientRepository $ingredientRepository
    )
    {
        $this->session = $session;
        $this->categoryRepository = $categoryRepository;
        $this->ingredientsManager = $ingredientsManager;
        $this->categoryManager = $categoryManager;
        $this->recipeRepository = $recipeRepository;
        $this->recipeHasCategoryRepository = $recipeHasCategoryRepository;
        $this->ingredientRepository = $ingredientRepository;
    }

    //get request
    /*
        $step = $request->get('step');
        $step = (!is_null($step) && $step === '2') ? 2 : 1;
        dump($step);

        if ($step === 1){
            return $this->AddRecipeStep1($request);
        }


        return $this->AddRecipeStep2($request);
    */

    /**
     * @Route("/new/recipe", name="recipe_new")
     * @return Response
     */
    public function index(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeFormType::class, $recipe, ['category_options' => $this->categoryManager->getAllCategoriesByName()]);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();





        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $uploadsDir = $this->getParameter('uploads_directory');
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move( $uploadsDir, $fileName);

            $temporaryFile = new ImageTemporary();
            $temporaryFile->setFileName($fileName);
            $temporaryFile->setUserId(1);
            $entityManager->persist($temporaryFile);
//            $fileName = "test";


            $text = $form->get('text')->getData();
            $recipe->setText($text);

            $name = $form->get('name')->getData();
            $recipe->setName($name);

            $recipe->setImage($fileName);
            //todo
            $recipe->setUserId($this->getUser()->getId());

            $entityManager->persist($recipe);
            $entityManager->flush();

            $ingredients = [];
            $ingredientsData = $form->get('ingredients')->getData()['transformed'];
            foreach ($ingredientsData as $data){
                $unit = isset($data['unit']) ? $data['unit'] : " ";
                $ingredient = new Ingredient();
                $ingredient->setName($data['name']);
                $ingredient->setAmount($data['amount']);
                $ingredient->setUnit($unit);
                $ingredient->setRecipeId($recipe->getId());
                $ingredients[] = $ingredient;
            }
            $this->ingredientsManager->setNewIngredients($recipe, $ingredients);

            $categoriesData = $form->get('categories')->get('categories')->getData();
            $categories = [];
            foreach ($categoriesData as $categoryId){
                $category = new RecipeHasCategory();
                $category->setRecipeId($recipe->getId());
                $category->setCategoryId($categoryId);
                $categories[] = $category;
            }
            $this->categoryManager->setNewCategories($recipe, $categories);


            $this->addFlash('success', 'Updated.');
            return $this->redirectToRoute('main_page');
        }


        return $this->render('recipe/new.html.twig', [
            'form' => $form->createView(),
            'ingredientsN' => 2
        ]);

    }

    /**
     * @Route("/edit/recipe/{id}", name="recipe_edit")
     * @return Response
     */
    public function edit(Request $request, $id): Response
    {
        $recipe = $this->recipeRepository->findOneById($id);
        if (!$this->canEdit($recipe)){
            $this->addFlash('danger', 'you dont have access to this page..');
            return $this->redirectToRoute('main_page');
        }


        dump($this->ingredientRepository->findByRecipeId($recipe->getId()));
        $form = $this->createForm(RecipeFormType::class, $recipe, [
            'category_options' => $this->categoryManager->getAllCategoriesByName(),
            'category_selected' => $this->categoryManager->getCategories($recipe),
            'ingredients_data' => $this->ingredientRepository->findByRecipeId($recipe->getId()),
            'require_image' => false,
            ]);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();

        $ingredientsN = count($this->categoryManager->getCategories($recipe));
        $ingredientsN += ($ingredientsN === 1 ) ? 2 : 1;


        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image')->getData();
            if (!is_null($file)) {
                $uploadsDir = $this->getParameter('uploads_directory');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($uploadsDir, $fileName);
                $recipe->setImage($fileName);
            }

            $text = $form->get('text')->getData();
            $recipe->setText($text);

            $name = $form->get('name')->getData();
            $recipe->setName($name);


            //todo
            $recipe->setUserId($this->getUser()->getId());

//            $entityManager->persist($recipe);
            $entityManager->flush();

            $ingredients = [];
            $ingredientsData = $form->get('ingredients')->getData()['transformed'];
            foreach ($ingredientsData as $data){
                $ingredient = new Ingredient();
                $unit = isset($data['unit']) ? $data['unit'] : " ";
                $ingredient->setName($data['name']);
                $ingredient->setAmount($data['amount']);
                $ingredient->setUnit($unit);
                $ingredient->setRecipeId($recipe->getId());
                $ingredients[] = $ingredient;
            }
            $this->ingredientsManager->setNewIngredients($recipe, $ingredients);

            $categoriesData = $form->get('categories')->get('categories')->getData();
            $categories = [];
            foreach ($categoriesData as $categoryId){
                $category = new RecipeHasCategory();
                $category->setRecipeId($recipe->getId());
                $category->setCategoryId($categoryId);
                $categories[] = $category;
            }
            $this->categoryManager->setNewCategories($recipe, $categories);


            $this->addFlash('success', 'Updated.');
            return $this->redirectToRoute('main_page');
        }


        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
            'ingredientsN' => $ingredientsN,
        ]);

    }

    /**
     * @Route("/detail/recipe/{id}", name="recipe_detail")
     * @return Response
     */
    public function detail(Request $request, $id): Response
    {
        $recipe = $this->recipeRepository->findOneById($id);
        $ingredients = $this->ingredientRepository->findByRecipeId($recipe->getId());
        $categories = $this->categoryRepository->findByRecipeIdd($recipe->getId());


        return $this->render('recipe/detail.html.twig', [
            'recipe' => $recipe,
            'ingredients' => $ingredients,
            'categories' => $categories,
            'canEdit' => $this->canEdit($recipe)
        ]);
    }

    /**
     * @Route("/delete/recipe/{id}", name="recipe_delete")
     * @return Response
     */
    public function delete(Request $request, $id): Response
    {

        $recipe = $this->recipeRepository->findOneById($id);
        if (!$this->canEdit($recipe)){
            $this->addFlash('danger', 'you dont have access to this page..');
            return $this->redirectToRoute('main_page');
        }

        $ingredients = $this->ingredientRepository->findByRecipeId($recipe->getId());
        $categories = $this->recipeHasCategoryRepository->findByRecipeId($recipe->getId());

        $entityManager = $this->getDoctrine()->getManager();
        foreach ($ingredients as $ingredient){
            $entityManager->remove($ingredient);

        }
        foreach ($categories as $category){
            $entityManager->remove($category);

        }
        $entityManager->remove($recipe);
        $entityManager->flush();



        return $this->redirectToRoute('main_page');

    }

    private function canEdit(Recipe $recipe): bool
    {
        return ($this->isLoggedIn() && ($this->isAdmin() || $this->getUser()->getId() == $recipe->getUserId()));
    }
}
