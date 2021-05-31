<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('query', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder'=> 'search recipe'],
                'required'=>false,
            ])
            ->add('ingredient', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder'=> 'search ingredient'],
                'required'=>false,
                'label' => false
            ])
            ->add('search', SubmitType::class, [
                'attr' => ['class' => 'btn btn-secondary'],
            ])
            ->add('categories', CategoriesFormType::class, [
                'mapped' => false,
                'category_options' => $options['category_options'],
                'category_selected' => $options['category_selected'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'category_options' => [],
            'category_selected' => [],
        ]);
    }
}
