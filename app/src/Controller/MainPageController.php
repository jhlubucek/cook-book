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
        $form = $this->createForm(SearchFormType::class, null, ['category_options' => $this->categoryManager->getAllCategories()]);

        $this->addFlash('success', 'Updated.');

        $form->handleRequest($request);
        dump($form);
        dump($form->isSubmitted());
        if ($form->isSubmitted() && $form->isValid()) {
            $query = $form->get('query')->getData();
            $categories = $form->get('categories')->get('categories')->getData();
            $ingredient = $form->get('ingredient')->getData();
            $query = is_null($query) ? "%%" : "%$query%";
            dump($query);
            dump($categories);
            dump($ingredient);
            if ($categories == [] && is_null($ingredient)){
                $recipesAll = $this->recipeRepository->findByNameLike('%' . "$query" . "%");
            }else {
                if (!$categories == []) {
                    $filter = $this->recipeHasCategoryRepository->findIdsByCategoryId($categories);
                } else if (!is_null($ingredient)) {
                    $filter = $this->ingredientRepository->findRecipeIdByNameLike('%' . $ingredient . '%');
                } else {
                    $categoryFilter = $this->recipeHasCategoryRepository->findIdsByCategoryId($categories);
                    $ingredientFilter = $this->ingredientRepository->findRecipeIdByNameLike('%' . $ingredient . '%');
                    $filter = array_intersect($categoryFilter, $ingredientFilter);

                }
                $recipesAll = $this->recipeRepository->findByNameAndIdIn('%' . $query . "%", $filter);
            }


//            $categoryFilter = $this->recipeHasCategoryRepository->findIdsByCategoryId($categories);
//            $ingredientFilter = $this->ingredientRepository->findRecipeIdByNameLike('%'. $ingredient .'%');
//
//            $filter = array_intersect($categoryFilter, $ingredientFilter);
//            dump($categoryFilter);
//            dump($ingredientFilter);
//            dump($filter);
//            dump($this->recipeRepository->findByNameAndIdIn('%' . $query . "%", [92,93]));
//            $recipesAll = $this->recipeRepository->findByNameLike('%' . "$query" . "%");
        }else{
            $recipesAll = $this->recipeRepository->findAll();
        }






        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'recipes' => $recipesAll,
            'form' => $form->createView(),
        ]);
    }
}
