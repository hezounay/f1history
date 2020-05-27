<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;


// use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function index(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'hasError' => $error !==null,
            'username' => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     * @Route("/logout", name="account_logout")
     *
     * @return Response
     */
    public function logout(){
        //...
    }

    /**
     * Permet d'afficher le formulaire d'inscription
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();

        $form = $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash= $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été créé'
            );


            return $this->redirectToRoute('account_login');
            }

          

        return $this->render('account/registration.html.twig',[
            "myForm" => $form->createView()
        ]);

    
   }


    /**
     * Permet de modifier le mot de passe
     * @Route("/account/password-update", name="account_password")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function updatePassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $passwordUpdate = new PasswordUpdate(); // fausse entité

        $user = $this->getUser(); // récup l'utilisateur connecté

        $form = $this->createForm(PasswordUpdateType::class,$passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // vérification que le mot de passe corresponde à l'ancien (oldPassword)
            if(!password_verify($passwordUpdate->getOldPassword(),$user->getPassword())){
                // gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez inséré n'est pas le bon mot de passe"));
            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user,$newPassword);

                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien été modifié'
                );

                return $this->redirectToRoute('account_index');
            }
        }

        return $this->render('account/password.html.twig',[
            'myForm' => $form->createView()
        ]);


    }

}
