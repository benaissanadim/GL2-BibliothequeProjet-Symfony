<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pricemin', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez ',
                ],
                'required' => false
            ])
            ->add('pricemax', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez ',
                ],
                'required' => false
            ])
            ->add('FilterPrice', SubmitType::class, [
                'attr' => [
                    'class' => 'btn',
                ]
            ])
        ;



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
