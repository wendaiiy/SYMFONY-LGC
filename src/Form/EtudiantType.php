<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'attr'=>["class" =>"form-control mt-2"], 
            ])
            ->add('prenom', TextType::class, [
                'attr'=>["class" =>"form-control mt-2"], 
            ])
            ->add('etude', TextType::class, [
                'attr'=>["class" =>"form-control mt-2"], 
            ])
            ->add('valider', SubmitType::class,[
                'attr'=>["class" =>"d-grid gap-2 col-6 mx-auto mt-2 btn btn-secondary"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
