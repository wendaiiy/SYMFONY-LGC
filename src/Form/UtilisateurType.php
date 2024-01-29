<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class , [
                'attr'=>["class" =>"form-control mt-2"], 
            ])
            ->add('prenom', TextType::class, [
                'attr'=>["class" =>"form-control mt-2"], 
            ])
            ->add('email', EmailType::class, [
                'attr'=>["class" =>"form-control mt-2"], 
            ])
            ->add('password', RepeatedType::class,  [
                "type" => PasswordType::class, 
                'attr'=>["class" =>"form-control mt-2"], 
                "first_options"=>["label"=> "Mot de passe", "attr"=>["class" => "form-control"]], 
                "second_options" =>["label"=> "Mot de passe verification", "attr"=>["class" => "form-control"]]
            ])
            ->add('roles', ChoiceType::class, [
                'attr'=>["class" =>"form-select"],
                "multiple" => true,
                "choices" => [
                    "administrateur" =>"ROLE_ADMIN",
                    "client" => "ROLE_CLIENT"
                ]
            ])
            ->add('valider', SubmitType::class,[
                'attr'=>["class" =>"d-grid gap-2 col-6 mx-auto mt-2 btn btn-secondary"]
            ])
            
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
