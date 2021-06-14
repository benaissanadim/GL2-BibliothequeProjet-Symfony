<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CantactMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Subject', TextType::class,[
            'label' => 'Subject',
                'attr' => [
                'class' => 'form-control',
                'placeholder' =>'Your subject',
                    ]
                    ])

            ->add('email', EmailType::class,[
                'label' => 'Subject',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' =>'Your subject',
                ]
            ])
            ->add('message', TextareaType::class ,[
                'label' => 'Your message',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' =>'your comment',
                ]
            ])
            ->add('send', SubmitType::class,[
                'attr' => [
                    'class' => 'btn',
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}