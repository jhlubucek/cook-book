<?php

namespace App\Controller;

use App\Entity\ImageTemporary;
use App\Entity\Recipe;
use App\Form\IngredientsFormType;
use App\Form\RecipeFormType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class RecipeController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/new/recipe", name="recipe_new")
     * @return Response
     */
    public function index(Request $request): Response
    {
        $step = $request->get('step');
        $step = (!is_null($step) && $step === '2') ? 2 : 1;
        dump($step);

        if ($step === 1){
            return $this->AddRecipeStep1($request);
        }


        return $this->AddRecipeStep2($request);


    }

    private function AddRecipeStep1(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->add('next', SubmitType::class);
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

            $text = $form->get('text')->getData();
            $recipe->setText($text);

            $name = $form->get('name')->getData();
            $recipe->setName($name);

            $recipe->setImage($fileName);
            //todo
            $recipe->setUserId(1);

//            dump($form->);

            $entityManager->persist($recipe);
            $entityManager->flush();
            $this->addFlash('success', 'Updated.');
//            return $this->redirectToRoute('recipe_new',['step' => 2]);

        }
        return $this->render('recipe/newStep1.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function AddRecipeStep2(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(IngredientsFormType::class);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//
//            return $this->redirectToRoute('recipe_new',['step' => 2]);
        }
        return $this->render('recipe/newStep2.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function extractIngredientsFromForm(RecipeFormType $form){
//        for
    }
}
