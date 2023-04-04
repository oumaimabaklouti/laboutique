<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[ 
                'label' => 'Quel nom souhaitez-vous donner à votre adresse?',
                'attr' => [  
                    'placeholder'=>'Nommez votre adresse'
                ]
                ])
            ->add('firstname', TextType::class,[ 
                'label' => 'Votre prénom',
                'attr' => [  
                    'placeholder'=>'Entrez votre prénom'
                ]
                ])
            ->add('lastname', TextType::class, [ 
                'label' => 'Votre nom',
                'attr' => [  
                    'placeholder'=>'Entrez votre nom'
                ]
                ])
            ->add('company', TextType::class,[ 
                'label' => 'Votre société?',
                'required'=>false,
                'attr' => [  
                    'placeholder'=>'Quel est votre société?(sinon mettez non)'
                ]
                ])
            ->add('adress', TextType::class,[ 
                'label' => 'Votre adresse?',
                'attr' => [  
                    'placeholder'=>'8 rue des Lilas...'
                ]
                ])
            ->add('postal', TextType::class,[ 
                'label' => 'Code postal ?',
                'attr' => [  
                    'placeholder'=>'7000'
                ]
                ])
            ->add('city', TextType::class,[ 
                'label' => 'Ville ?',
                'attr' => [  
                    'placeholder'=>'Entrez votre ville'
                ]
                ])
            ->add('country', CountryType::class,[ 
                'label' => 'Pays ?',
                'attr' => [  
                    'placeholder'=>'Entrez votre pays'
                ]
                ])
            ->add('phone', TelType::class,[ 
                'label' => 'Votre téléphone?',
                'attr' => [  
                    'placeholder'=>'06..',
                ]
                ])
            ->add('submit', SubmitType::class,[  
                'label'=> 'Valider',
                'attr' => [  
                    'class'=>'btn-block btn-info',
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
