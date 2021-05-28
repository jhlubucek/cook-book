<?php

namespace App\Form;

use App\Entity\Recipe;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use function Sodium\add;

class RecipeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
//                'required' => true,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9áčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ\-]{2,20}$/',
                        'message' => "2-20 characters. Only letters numbers and -. "
                    ]),
                ]
            ])
            ->add('text', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('image', FileType::class,[
                'attr' => ['class' => 'form-upload'],
                'mapped' => false,
                'label' => 'select image: '
            ]);

        $this->buildIngredients($builder);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }

    private function buildIngredients(FormBuilderInterface $builder){
        for($i = 1; $i<=10; $i++) {
            $builder->add('ingredient'.$i, TextType::class, [
                "mapped" => false,
//                'attr' => [ 'style' => "display: none;"],
                'attr' => [ 'placeholder' => "ingredient", 'class' => 'ingredient-name form-control'],
                'label' => false,
                'required' => false,
            ])
                ->add('ingredient_count'.$i, TextType::class, [
                    "mapped" => false,
                    'attr' => ['class' => 'test form-control', 'placeholder'=> 'amount'],
                    'label' => false,
                    'required' => false,
                ])
                ->add('ingredient_unit'.$i, ChoiceType::class, [
                    "mapped" => false,
                    'attr' => ['class' => 'test form-control'],
                    'label' => false,
                    'choices'  => [
                        'Maybe' => 1,
                        'Yes' => 2,
                        'No' => 3,
                    ],
                    'required' => false,
                ]);
        }
    }
}
