<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('nickname', TextType::class, [
                'label' => 'You Name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' =>'Write yourName',
                ]
            ])
            ->add('content', TextareaType::class ,[
                'label' => 'Your comment',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' =>'your comment',
                ]
            ])
            ->add('createdAt', HiddenType::class,)
            ->add('updtaedAt', HiddenType::class,)


            ->add('parentid', HiddenType::class, [
                'mapped' => false
            ])
            ->add('stars', HiddenType::class, [
                'mapped' => false
            ])
            ->add('submit', SubmitType::class ,[
                'attr' => [
                    'class' => 'btn',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
