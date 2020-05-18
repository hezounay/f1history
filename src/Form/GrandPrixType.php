<?php

namespace App\Form;

use App\Form\ImageType;
use App\Entity\GrandPrix;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class GrandPrixType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder'=>"Nom du Grand-Prix"
                ]
            ])
            ->add('slug', TextType::class, $this->getConfiguration('slug','Adresse web (automatique)',[
                'required' => false
            ]))
            ->add('date', DateTimeType::class, $this->getConfiguration('Date','Date où le Grand-Prix a eu lieu'))
            ->add('map', UrlType::class, $this->getConfiguration('Carte du circuit','ajoutez l\'URL de la carte du circuit'))
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true, // permet d'ajouter de nouveaux éléments et ajouter un data_prototype (HTML)
                    'allow_delete' => true // permet de supprimer des éléments
                ]
            )
            ->add('description', TextareaType::class, $this->getConfiguration('Description détaillée','Donnez une description du circuit'));
           
           
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GrandPrix::class
        ]);
    }
}