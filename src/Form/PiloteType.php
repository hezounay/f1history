<?php


namespace App\Form;

use App\Entity\Pilote;
use App\Form\ImageType;
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


class PiloteType extends AbstractType
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
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder'=>"Prénom du Pilote"
                ]
            ])
            ->add('nationalite', TextType::class, [
                'label' => 'Nationalité',
                'attr' => [
                    'placeholder'=>"Nationalité du Pilote"
                ]
            ])
            ->add('datenaissance', DateTimeType::class, [
                'label' => 'Date de naissance',
                'attr' => [
                    'placeholder'=>"Date de naissance du Pilote"
                ]
            ])
            ->add('actif', CheckboxType::class, [
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


