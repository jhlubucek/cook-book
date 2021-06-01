<?php

namespace App\Controller;

use App\Entity\RecipeHasCategory;
use App\Form\SearchFormType;
use App\Repository\CategoryRepository;
use App\Repository\IngredientRepository;
use App\Repository\RecipeHasCategoryRepository;
use App\Repository\RecipeRepository;
use App\Service\CategoryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    private $recipeRepository;
    private $categoryRepository;
    private $recipeHasCategoryRepository;
    private $ingredientRepository;
    private $categoryManager;

    private static $NAME_VAR = "name";
    private static $INGREDIENT_VAR = "ingredient";

    public function __construct(
        RecipeRepository $recipeRepository,
        CategoryRepository$categoryRepository,
        RecipeHasCategoryRepository $recipeHasCategoryRepository,
        IngredientRepository $ingredientRepository,
        CategoryManager $categoryManager
    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->recipeHasCategoryRepository = $recipeHasCategoryRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->categoryManager = $categoryManager;
    }

    /**
     * @Route("/", name="main_page")
     */
    public function index(Request $request): Response
    {

        dump($_GET);
        dump($request->get("kokos_koko"));
        $allCategoriesByName = $this->categoryManager->getAllCategoriesByName();
        $searchCategories = [];
        $selectedCategories = [];
        foreach ($allCategoriesByName as $name => $id){
            $urlName = str_replace(" ", "_", $name);
            if ($request->get($urlName) == 1){
                $searchCategories[] = $id;
                $selectedCategories[] = $name;
            }
        }
        $searchName = $request->get(self::$NAME_VAR);
        $searchIngredient = $request->get("ingredient");



        dump($searchName,$searchIngredient, $searchCategories, $selectedCategories);


        $form = $this->createForm(SearchFormType::class, null, [
            'category_options' => $this->categoryManager->getAllCategoriesByName(),
            'category_selected' => $selectedCategories,
            'data' => ['query' => $searchName, 'ingredient' => $searchIngredient]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->get('query')->getData();
            $categoriesForm = $form->get('categories')->get('categories')->getData();
            $ingredient = $form->get('ingredient')->getData();

            $allCategoriesById = $this->categoryManager->getAllCategoriesById();

            $params = [];

            $params[self::$NAME_VAR] = $name;
            $params[self::$INGREDIENT_VAR] = $ingredient;
            foreach ($categoriesForm as $id){
                $params[$allCategoriesById[$id]] = "1";
            }

            dump($form->getData());
            return  $this->redirectToRoute('main_page', $params);
        }

        dump(empty($searchCategories));
        dump(empty($searchIngredient));

        if (empty($searchCategories) && empty($searchIngredient)){
            $recipesAll = $this->recipeRepository->findByNameLike('%' . "$searchName" . "%");
        }else {
            if (empty($searchIngredient)) {
                $filter = $this->recipeHasCategoryRepository->findIdsByCategoryId($searchCategories);
            } else if (empty($searchCategories)) {
                $filter = $this->ingredientRepository->findRecipeIdByNameLike('%' . $searchIngredient . '%');
            } else {
                $categoryFilter = $this->recipeHasCategoryRepository->findIdsByCategoryId($searchCategories);
                $ingredientFilter = $this->ingredientRepository->findRecipeIdByNameLike('%' . $searchIngredient . '%');
                $filter = array_intersect($categoryFilter, $ingredientFilter);
                dump($categoryFilter);
                dump($ingredientFilter);
                dump($filter);

            }
            $recipesAll = $this->recipeRepository->findByNameAndIdIn('%' . $searchName . "%", $filter);
        }

//        $recipesAll = $this->recipeRepository->findByNameLike('%' . "" . "%");





        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'recipes' => $recipesAll,
            'form' => $form->createView(),
        ]);
    }
}
