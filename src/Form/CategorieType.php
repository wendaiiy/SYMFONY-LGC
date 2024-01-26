<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('description', TextareaType::class, [
                'attr'=>["class" =>"form-control mt-2"],                
                'label' => "Description :"
            ])
            ->add('nom', TextType::class, [
                'attr'=>["class" =>"form-control mt-2"],
                'label'=>'Nom :'                
            ])
           
            ->add('Valider', SubmitType::class, [
                'attr'=>["class" =>"d-grid gap-2 col-6 mx-auto mt-2 btn btn-secondary"]
            ])         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
