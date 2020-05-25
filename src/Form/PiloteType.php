<?php


namespace App\Form;

use App\Entity\Team;
use App\Entity\Pilote;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class PiloteType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder'=>"Prénom du Pilote"
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder'=>"Nom du Pilote"
                ]
            ])
            ->add('nationalite', CountryType::class, [
                'label' => 'Nationalité',
              ])
            ->add('datenaissance', DateTimeType::class, [
                'label' => 'Date de naissance',
                'attr' => [
                    'placeholder'=>"Date de naissance du Pilote"
                ]
            ])
            ->add('team', EntityType::class, [
                'label' => 'Ecurie',
                'attr' => [
                    'placeholder'=>"Ecurie du Pilote"
                ],
                'class' => Team::class,
                'choice_label' => function($team){
                    return $team->getNom();
                }
            ])
            ->add('picture', UrlType::class, [
                'label' => 'Photo du Pilote',
                'attr' => [
                    'placeholder'=>"ajoutez l'URL de la photo du Pilote"
                ]
            ])
            ->add('actif', ChoiceType::class, [
                'label' => 'Activité'
                
                    
                
               
                ]
            );
            

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pilote::class
        ]);
    }
}


