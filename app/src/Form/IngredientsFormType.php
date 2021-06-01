<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use function Sodium\add;

class IngredientsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $nIngredients = count($options['ingredients_data']);
        $nIngredients += $nIngredients == 0 ? 1 :0;

        for($i = 1; $i<=10; $i++) {
            $hidden = $i <= $nIngredients ? "" : "display: none;";
            $builder->add('ingredient_name_'.$i, TextType::class, [
//                "mapped" => false,
                'attr' => [ 'placeholder' => "ingredient", 'class' => 'ingredient-name form-control', 'style' => $hidden],
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9áčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ\- ]{0,20}$/',
                        'message' => "0-20 characters. Only letters numbers and -. "
                    ]),
                ]
            ])
                ->add('ingredient_amount_'.$i, NumberType::class, [
//                    "mapped" => false,
                    'attr' => ['class' => 'test form-control', 'placeholder'=> 'amount', 'style' => $hidden],
                    'label' => false,
                    'required' => false,
                    'invalid_message' => 'amount must be a number',
                    'constraints' => [
                        new Range([
                                'min' => 0,
                                'max' => 999,
                                'notInRangeMessage' => 'value must be between 0 and 999',
                            ]
                        ),
                    ]
                ])
                ->add('ingredient_unit_'.$i, ChoiceType::class, [
//                    "mapped" => false,
                    'attr' => ['class' => 'test form-control', 'style' => $hidden],
                    'label' => false,
                    'choices'  => [
                        'Kg' => 'Kg',
                        'g' => 'g',
                        'l' => 'l',
                        'ml' => 'ml',
                        'table spoon' => 'table spoon',
                        'spoon' => 'spoon',
                        'piece' => 'piece'

                    ],
                    'required' => false,
                ])
                ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $result = [];
                    $change = false;
                    foreach ($data as $key => $val){
                        $name = explode('_', $key);
                        if (count($name) == 3){
                            $change = true;
                            $num = $name[2];
                            $type = $name[1];
                            if ($type == 'name' && !empty($val)){
                                $result[$num]['name'] = $val;
                                if (!isset($result[$num]['amount'])){
                                    $result[$num]['amount'] = "";
                                }
                            }
                            if ($type == 'amount' && !empty($val)){
                                $result[$num]['amount'] = $val;
                            }
                            if ($type == 'unit' && !empty($val)){
                                $result[$num]['unit'] = $val;
                            }
                        }

                    }
                    if ($change){
                        foreach ($result as $key => $row){
                            if ($this->invalidTransformedData($row)){
//                                dump("chyba  "."ingredient_name_$key");
                                $form->get("ingredient_name_$key")->addError(new FormError('name must be set'));
//                                dump($form->get("ingredient_name_$key")->getErrors());
                            }
                        }
                    $event->getForm()->setData(['transformed' => $result]);
                    }
                })
                ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $form->getData()['transformed'];

                    foreach ($data as $key => $row){
                        if ($this->invalidTransformedData($row) && $form->get("ingredient_name_$key")->isValid()){
//                                dump("chyba  "."ingredient_name_$key");
                            $form->get("ingredient_name_$key")->addError(new FormError('name must be set'));
//                                dump($form->get("ingredient_name_$key")->getErrors());
                        }
                    }
                });

        }
        $data = [];

        dump($options['ingredients_data']);
        foreach ($options['ingredients_data'] as $key => $ingredient){
            $data['ingredient_name_'.($key + 1)] = $ingredient->getName();
            if (!empty($ingredient->getAmount()))
                $data['ingredient_amount_'.($key + 1)] = $ingredient->getAmount();
            $data['ingredient_unit_'.($key + 1)] = $ingredient->getUnit();
        }
        $builder->setData($data);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'ingredients_data' => []
        ]);
    }

    private function invalidTransformedData($data){
        if (!isset($data['name'])){
            return true;
        }
        return false;
    }
}
