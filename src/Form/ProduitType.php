<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Produit;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;



class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true])
            ->add('path')
            ->add('image', FileType::class, array(
                'mapped'=> false,
                'constraints'=> array(
                    new Image()
                )
            ))
            ->add('path2')
            ->add('image2', FileType::class, array(
                'mapped'=> false,
                'constraints'=> array(
                    new Image()
                )
            ))

            ->add('Add', SubmitType::class, [
                'attr' => ['label' => 'Add Product']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
