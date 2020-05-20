<?php

namespace App\Controller;

use App\Entity\Team;

use App\Form\TeamType;
use App\Form\PiloteType;
use App\Service\PaginationService;
use App\Repository\PiloteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTeamController extends AbstractController
{
    /**
     * @Route("/admin/team/{page<\d+>?1}", name="admin_team_index")
     */
    public function index($page, PaginationService $pagination)
    
    
    {
        
     
        $pagination->setEntityClass(Team::class)
        ->setPage($page)
        ->setLimit(10)
        ->setRoute('admin_team_index');

   
        return $this->render('admin/team/index.html.twig',[
            'pagination' => $pagination,
            
        ]);



     




    }

     /**
     * Permet d'afficher le formulaire d'édition
     * @Route("/admin/team/{id}/edit", name="admin_team_edit")
     *
     * @param Team $team
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Team $team, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(TeamType::class,$team);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($team);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$team->getNom()}</strong> a bien été modifiée"
            );
        }

        return $this->render('admin/team/edit.html.twig',[
            'team' => $team,
            'myForm' => $form->createView()
        ]);


    }

     /**
     * Permet de supprimer une annonce
     * @Route("/admin/team/{id}/delete", name="admin_team_delete")
     *
     * @param Team $team
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Team $team, EntityManagerInterface $manager){
        // on ne peut pas supprimer une team qui possède des Pilotes 
        if(count($team->getPilotes()) > 0){
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer l'écurie &nbsp  <strong>{$team->getNom()}</strong> car elle possède  des pilotes"
            );
        }else{
            $manager->remove($team);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'écurie &nbsp <strong>{$team->getNom()}</strong> a bien été supprimée"
            );
        }

        return $this->redirectToRoute('admin_team_index');

    }
    
}