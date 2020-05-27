<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Stats;
use App\Entity\Pilote;
use App\Entity\GrandPrix;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
        ->add('annee', EntityType::class, [
            'label' => 'Année',
            'attr' => [
                'placeholder'=>"Année du Grand-Prix"
            ],
            'class' => GrandPrix::class,
            'choice_label' => function($grandprix){
                return $grandprix->getDate();
            }
        ])
        ->add('chrono', TextType::class, [
            'label' => 'Chrono',
            'attr' => [
                'placeholder'=>"Chrono effectué"
            ]
        ])
            ->add('pilote', EntityType::class, [
                'label' => 'Pilote',
                'attr' => [
                    'placeholder'=>"Nom et prénom du Pilote"
                ],
                'class' => Pilote::class,
                'choice_label' => function($pilote){
                    return $pilote->getPrenom().' '.$pilote->getNom();
                }
            ])
            ->add('grandPrix', EntityType::class, [
                'label' => 'Grand-Prix',
                'attr' => [
                    'placeholder'=>"Grand-Prix"
                ],
                'class' => GrandPrix::class,
                'choice_label' => function($grandprix){
                    return $grandprix->getTitle();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stats::class,
        ]);
    }
}
