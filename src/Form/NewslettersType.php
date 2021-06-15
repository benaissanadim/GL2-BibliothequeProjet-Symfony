<?php

namespace App\Form;

use App\Entity\Newsletters\Newsletters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewslettersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Subject',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' =>'Your subject',
                ]
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Your message',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' =>'your newslettercontent',
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
            'data_class' => Newsletters::class,
        ]);
    }
}
