<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert ;


class SearchBarType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {

        $dateEnd = intval(date("Y")) ;
  
        $builder
            ->add('category',  EntityType::class, [
                "class" => Category::class,
                "choice_label" => "name",
                'required' => false,
                'attr' => [
                    'class' => 'form-select form-select-sm',
                ],                
                'label'=>'Catégorie : ',

            ])
            ->add('price', NumberType::class,[
                'attr' => [
                    'class' => 'form-control',
                ],
                'label'=>'Prix : ',
                'required' => false,
                'constraints' => [
                    new Assert\PositiveOrZero(),
                ]
            ])
            ->add('date', DateType::class,[
                'widget' => 'choice',
                'years'=> range(1960, $dateEnd),
                'attr' => [
                    'class' => 'form-control',
                ],
                'label'=>'Date : ',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher'
            ])
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
