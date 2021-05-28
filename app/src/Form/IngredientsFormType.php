<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use function Sodium\add;

class IngredientsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
