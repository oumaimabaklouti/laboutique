<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', Texttype::class,[
            'label' =>'Votre prénom',
            'constraints'=> new length(30,2),
            'attr' => [
                'placeholder' => 'Merci de saisir votre prénom' 
                ]
                ])
        ->add('lastname', Texttype::class, [
            'label' =>'Votre nom',
            'constraints'=> new length(30,2),
            'attr' => [
                'placeholder' => 'Merci de saisir votre nom' 
                ]
                ])
        ->add('email', EmailType::class,  [
            'label' =>'Votre email',
            'constraints'=> new length(30,2),
            'attr' => [
                'placeholder' => 'Merci de saisir votre adresse Email' 
                ]
                ])
        ->add('password', RepeatedType::class,[
            'type' => PasswordType::class,
            'invalid_message' =>'le mot de passe et la confirmation doivent être identique',
            'label' =>'Votre mot de passe',
            'required'=>true,
            'first_options'=> [
                'label' =>'Votre mot de passe',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre mot de passe' 
                    ]
                ],
            'second_options'=> [
                 'label' =>'Confirmez votre mot de passe',
                 'attr' => [
                    'placeholder' => 'Merci de confirmer votre mot de passe' 
                    ]
                 ]
                 ])
        ->add('submit', SubmitType::class,[
            'label' =>"s'inscrire"
            ])
            ;
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
