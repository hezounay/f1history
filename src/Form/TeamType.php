<?php


namespace App\Form;

use App\Entity\Team;
use App\Form\ImageType;
use App\Form\PiloteType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class TeamType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder'=>"Nom du Pilote"
                ]
            ])
            ->add('moteur', TextType::class, [
                'label' => 'Moteur',
                'attr' => [
                    'placeholder'=>"Moteur utilisé"
                ]
            ])
            ->add('pays', TextType::class, [
                'label' => 'Localisation',
                'attr' => [
                    'placeholder'=>"Localisation de la Team"
                ]
            ])
            ->add(
                'pilote',
                CollectionType::class,
                [
                    'entry_type' => PiloteType::class,
                    'allow_add' => true, // permet d'ajouter de nouveaux éléments et ajouter un data_prototype (HTML)
                    'allow_delete' => true // permet de supprimer des éléments
                ]
                );
           
            
            
            
           
          
           
           
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Team::class
        ]);
    }
}
