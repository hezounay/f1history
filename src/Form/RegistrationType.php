<?php

namespace App\Form;

use App\Entity\User;

use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("Prenom", "Votre prénom..."))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom..."))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse e-mail..."))
            ->add('password', PasswordType::class, $this->getConfiguration("Mot de passe","Veuillez entrer votre mot de passe"))
           
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirmation de mot de passe","Veuillez confirmer votre mot de passe"))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => [
                'Default',
                'front'
            ]
        ]);
    }
}
