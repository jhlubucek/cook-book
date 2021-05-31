<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\CategoryRepository;

class CategoriesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            "categories",
            ChoiceType::class,
            [
                'label' => 'select categories',
                'attr' => ['class' => 'categories-form'],
                'choices' => [
                    $options['category_options']
                ],
                'choice_attr' => $this->createChoiceAttr($options['category_selected']),
                'expanded' => true,
                'multiple' => true,
                'required' => false,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'category_options' => [],
            'category_selected' => [],
        ]);
    }

    private function createChoiceAttr($categories){
        $result = [];
        foreach ($categories as $category){
            $result[$category] =  ['checked' => 'checked'];
        }
        dump($result);
        return $result;
    }
}
