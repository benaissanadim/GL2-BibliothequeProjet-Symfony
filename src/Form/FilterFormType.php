<?php


namespace App\Form;


use App\Entity\Category;
use App\Filter\FindByFilter;
use PhpParser\Node\Expr\Array_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterFormType extends AbstractType
{
        public function buildForm(FormBuilderInterface $builder , array $options)
        {
            $builder
            ->add('categories', EntityType::Class, [
                'label' => false ,
                'required' => false,
                'class' => Category::class,
                'expanded'=> true ,
                'multiple' => true
        ])
                ->add('min', NumberType::class , [
                    'label' => false ,
                    'required' => false,
                    'attr' => [
                        'placeholder' =>'minprice'
                    ]
                ])
                ->add('max', NumberType::class , [
                    'label' => false ,
                    'required' => false,
                    'attr' => [
                        'placeholder' =>'maxprice'
                    ]
                ]);


        }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => FindByFilter::Class,
                'methidGet' => 'Get',
                'csrf_protection' => false
            ]);
        }
        public function getBlockPrefix()
        {
            return '';
        }

}