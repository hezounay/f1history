<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUserType;
use App\Repository\RoleRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users/{page<\d+>?1}", name="admin_users_index")
     */
    public function index($page, PaginationService $pagination)
    {
        $pagination->setEntityClass(User::class)
                ->setPage($page)
                ->setLimit(10)
                ;
        return $this->render('admin/user/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    

    /**
     * Permet de modifier un utilisateur
     * @Route("/admin/users/{id}/edit", name="admin_users_edit")
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(AdminUserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Les modifications ont bien été enregistrées'
            );
        }

        return $this->render('admin/user/edit.html.twig',[
            'user' => $user,
            'myForm' => $form->createView()
        ]);

    }


    /**
     * Permet de supprimer un utilisateur
     * @Route("/admin/users/{id}/delete", name="admin_users_delete")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(User $user, EntityManagerInterface $manager){
       

            $manager->remove($user);
            $this->addFlash(
                'success',
                "L'utilisateur <strong>{$user->getUsername()}</strong> a bien été supprimé"
            );
            $manager->flush();
        

        return $this->redirectToRoute('admin_users_index');
    }

    /**
     * Permet d'ajouter le rôle admin à un utilisateur
     * @Route("/admin/users/{id}/addAdmin", name="admin_users_add_admin")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @param RoleRepository $role
     * @return Response
     */
    public function addAdmin(User $user, EntityManagerInterface $manager, RoleRepository $role){
        $user->addUserRole($role->findOneByTitle('ROLE_ADMIN'));
        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le rôle administrateur a bien été ajouté"
        );
        return $this->redirectToRoute('admin_users_edit', ['id' => $user->getId()]);
    }


    /**
     * Permet de supprimer le rôle admin à un membre
     * @Route("/admin/users/{id}/delAdmin", name="admin_users_del_admin")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @param RoleRepository $role
     * @return Response
     */
    public function removeAdmin(User $user, EntityManagerInterface $manager, RoleRepository $role){
        $user->removeUserRole($role->findOneByTitle('ROLE_ADMIN'));
        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'warning',
            "Le rôle administrateur a bien été supprimé"
        );
        return $this->redirectToRoute('admin_users_edit', ['id' => $user->getId()]);
    }



}

